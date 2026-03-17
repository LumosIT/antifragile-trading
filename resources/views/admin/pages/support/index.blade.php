@extends('admin.layouts.app')
@section('title', 'Поддержка')

@section('styles')
    <style>
        .message-item.active {
            background-color: #e0e0ff;
        }

        li.odd {
            text-align: right !important;
        }

        #table_wrapper > div:nth-child(1) > div:nth-child(2) {
            display: none;
        }

        select {
            background-color: #fff !important;
        }

        .message-item:hover {
            background-color:#dadada;
        }

        .message-center {
            overflow: hidden;
            width: 100%;
        }

        .message-item {
            width: 100%;
            margin: 0;
            box-sizing: border-box;
            overflow: hidden;
            white-space: nowrap;
        }

        .message-item .user-img {
            flex-shrink: 0;
        }

        .message-item .w-75 {
            max-width: calc(100% - 50px);
            overflow: hidden;
        }

        .message-title {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 100%;
        }

        .font-12 {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 100%;
        }

        .ps-container {
            overflow-x: hidden !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-lg-4 col-xl-3 border-right" style="max-height: 770px;">
                        <div class="card-body border-bottom" style="border-right: 1px solid var(--default-border) !important;">
                            <input class="form-control" id="search" type="text" placeholder="Поиск">
                        </div>
                        <div class="message-center ps-container ps-theme-default" id="messagesBlock" style="width: 100%; height: 670px; border-right: 1px solid var(--default-border) !important;">
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-9" style="max-height: 770px; padding-left: 0;">
                        <div class="chat-box scrollable position-relative ps-container ps-theme-default">
                            <hr style="background: #8274ff">
                            <ul class="chat-list px-3 pt-3"
                                style="height: 599px; max-height: 599px; overflow: auto; list-style: none;"
                                id="block-messages">
                                <li>Выберите диалог</li>
                            </ul>
                            <div class="card-body border-top">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-field mt-0 mb-0">
                                            <div class="d-flex align-items-end">

                                                <textarea id="your-text"
                                                        class="border-cyan form-control"
                                                        rows="4"
                                                        style="resize:none;"></textarea>

                                                <div class="d-flex flex-column ms-2 gap-1">

                                                    <div id="file-preview" class="mt-2" style="display:none;"></div>

                                                    <div class="d-flex flex-column">
                                                        <label for="file-upload"
                                                            class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" style="width: 45px;">
                                                            📎
                                                        </label>
                                                        
                                                        <button class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center mt-1 mb-1"
                                                                style="width:45px"
                                                                id="record-audio">
                                                            🎤
                                                        </button>

                                                        <button class="btn btn-sm btn-primary d-flex align-items-center justify-content-center"
                                                                style="background:#8274ff; width: 45px"
                                                                id="send-message">
                                                            <i class="ri-mail-check-fill side-menu__icon"></i>
                                                        </button>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <input type="file" id="file-upload" accept="image/*,.pdf" style="display:none;">         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const textarea = document.getElementById("your-text");

        textarea.addEventListener("input", function () {
            this.style.height = "auto";
            this.style.height = this.scrollHeight + "px";
        });
    </script>
    <script>
        let currentDialog = null
        let currentClientId = null
        let lastDialogsHash = null;
        let lastMessageHash = null;

        $(document).ready(function () {
            getDialogs('all', true);

            setInterval(() => {
                getDialogs('all', false);
            }, 5000);

            setInterval(() => {
                if (currentDialog !== null) {
                    loadMessages(currentDialog);
                }
            }, 5000);
        })

        $(document).on('click', '.download-messages', function () {
            currentDialog = $(this).attr('data-dialog-id');
            currentClientId = $(this).attr('data-client-id');
            
            $('.download-messages').removeClass('active');
            $(this).addClass('active');

            loadMessages(currentDialog);
            $('#your-text').focus();
        });

        let timeout
        $('#search').on('change', function () {
            clearTimeout(timeout)
            timeout = setTimeout(() => {
                getDialogs(true)
            }, 500)
        })

        $('#send-message').on('click', function () {
            sendMessage();
        });

        $('#your-text').on('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        $('#file-upload').on('change', function () {
            const file = this.files[0];
            if (!file) return;

            let html = '';

            if (file.type.startsWith('image/')) {
                const url = URL.createObjectURL(file);
                html = `
                    <div class="align-items-center gap-2">
                        <div>📄 ${file.name}</div>
                        <button class="btn btn-sm btn-danger" id="remove-file">✖</button>
                    </div>
                `;

            } else {
                html = `
                    <div class="align-items-center gap-2">
                        <div>📄 ${file.name}</div>
                        <button class="btn btn-sm btn-danger" id="remove-file">✖</button>
                    </div>
                `;
            }
            $('#file-preview').html(html).show();
        });

        $(document).on('click', '#remove-file', function () {
            $('#file-upload').val('');
            $('#file-preview').hide().empty();
        });

        let mediaRecorder;
        let audioChunks = [];
        let isRecording = false;

        $('#record-audio').on('click', async function () {
            if (!isRecording) {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });

                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.ondataavailable = e => {
                    audioChunks.push(e.data);
                };

                mediaRecorder.onstop = sendAudio;

                mediaRecorder.start();
                isRecording = true;

                $('#record-audio').text('⏹');
            } else {

                mediaRecorder.stop();
                isRecording = false;
                $('#record-audio').text('🎤');
            }
        });

        function sendAudio() {
            const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });

            const formData = new FormData();
            formData.append('dialog_id', currentDialog);
            formData.append('client_id', currentClientId);
            formData.append('voice', audioBlob, 'voice.webm');

            $.ajax({
                type: 'POST',
                url: "/support/send-message",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        const msg = {
                            author: 'admin',
                            text: null,
                            file_exist: true,
                            file_path: response.file_path,
                            created_at: new Date().toISOString().slice(0,19).replace('T',' ')
                        };

                        $('#block-messages').append(buildMessageHtml(msg));

                        setTimeout(() => {
                            const block = $('#block-messages');
                            block.scrollTop(block[0].scrollHeight);
                        }, 50);
                    }
                }
            });
        }

        function getDialogs(forceRender = false) {
            let search = $('#search').val() == '' ? null : $('#search').val()

            $.ajax({
                type: 'post',
                data: {
                    value: search
                },
                url: "/support/get-dialogs",
                success: function (response) {
                    if (response.success) {
                        const newHash = response.hash;

                        if (!forceRender && lastDialogsHash === newHash) {
                            return;
                        }

                        lastDialogsHash = newHash;

                        const dialogs = response.dialogs;
                        const messagesBlock = $('#messagesBlock');
                        messagesBlock.empty();

                        dialogs.forEach(dialog => {
                            let profileName

                            if(dialog.username == '' || dialog.username == null || dialog.username == 'отсутсвует') {
                                profileName = 'Клиент'
                            } else {
                                profileName = dialog.username;
                            }

                            let imageUrl = dialog.image == null ? "{{ asset('/storage/avatar.png') }}" : dialog.image;
                            const activeClass = (currentDialog == dialog.id) ? 'active' : '';

                            const dialogHtml = `
                                <span class="message-item d-flex align-items-center border-bottom px-3 py-2 download-messages ${activeClass}"
                                    data-dialog-id="${dialog.id}" data-client-id="${dialog.client_id}">
                                    <div class="user-img mr-1">
                                        <img src="${imageUrl}" alt="avatar" class="rounded-circle current-avatar" width="40">
                                        <span class="profile-status online float-right"></span>
                                    </div>
                                    <div class="w-75 d-inline-block v-middle" style="padding-left:10px;">
                                        <p class="message-title mb-0 mt-1">
                                            <u>
                                                <a href="/admin/users/edit/${dialog.client_id}" target="_blank" style="color:inherit; text-decoration:none;">
                                                    ${profileName}
                                                </a>
                                            </u>
                                        </p>
                                        <span class="font-12 text-nowrap d-block text-dark text-truncate mt-2 mb-2">
                                            ${dialog.last_message ?? 'Нет сообщений'}
                                        </span>
                                        <span class="text-nowrap d-block text-muted" style="font-size: 0.6rem">
                                            ${dialog.created_at ?? ''}
                                        </span>
                                    </div>
                                    ${dialog.unread_count > 0 ? `
                                        <div class="ml-auto">
                                            <span class="badge" style="background:red">${dialog.unread_count}</span>
                                        </div>
                                    ` : ''}
                                </span>
                            `;

                            messagesBlock.append(dialogHtml);
                        });
                    }
                }
            });
        }

        function loadMessages(dialogId) {
            $.ajax({
                type: 'post',
                url: "/support/get-messages",
                data: {
                    dialog_id: dialogId
                },
                success: function (response) {
                    if (!response.success) return;

                    if (lastMessageHash === response.hash) return;

                    lastMessageHash = response.hash;

                    const messages = response.messages;
                    const block = $('#block-messages');
                    block.empty();

                    messages.forEach(msg => {
                        block.append(buildMessageHtml(msg));
                    });

                    setTimeout(() => {
                        block.scrollTop(block[0].scrollHeight);
                    }, 50);
                }
            });
        }

        function sendMessage() {
            const text = $('#your-text').val().trim();
            const fileInput = $('#file-upload')[0].files[0];

            if (currentDialog == null) {
                errorNotification('Сначала выберите диалог');
                return;
            }

            if (!text && !fileInput) {
                errorNotification('Введите текст или прикрепите фото');
                return;
            }

            const formData = new FormData();
            formData.append('text', text);
            formData.append('dialog_id', currentDialog);
            formData.append('client_id', currentClientId);
            if (fileInput) {
                formData.append('file', fileInput);
            }

            $.ajax({
                type: 'POST',
                url: "/support/send-message",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        $('#your-text').val('');
                        $('#file').val('');
                        const formatted = new Date().toISOString().slice(0, 19).replace('T', ' ');

                        const msg = {
                            author: 'admin',
                            text: text,
                            file_exist: !!response.file_path,
                            file_path: response.file_path,
                            created_at: formatted
                        };

                        $('#block-messages').append(buildMessageHtml(msg));

                        setTimeout(() => {
                            const block = $('#block-messages');
                            block.scrollTop(block[0].scrollHeight);
                            $('#remove-file').trigger('click');
                        }, 50);
                    } else {
                        errorNotification(response.message);
                    }
                }
            });
        }

        function buildMessageHtml(msg) {
            const isAdmin = msg.author === 'admin';
            let fileBlock = '';

            if (msg.file_exist && msg.file_path) {

                const lower = msg.file_path.toLowerCase();

                if (
                    lower.endsWith('.jpg') ||
                    lower.endsWith('.jpeg') ||
                    lower.endsWith('.png') ||
                    lower.endsWith('.gif') ||
                    lower.includes('/photos/') ||
                    lower.includes('i.oneme.ru')
                ) {
                    fileBlock = `
                        <div class="mt-2">
                            <a href="${msg.file_path}" target="_blank"><img src="${msg.file_path}" style="max-width:200px;border-radius:10px;"></a>
                        </div>
                    `;
                } else if (msg.file_exist && msg.file_path) {
                    const lower = msg.file_path.toLowerCase();

                    if (lower.endsWith('.webm') || lower.endsWith('.ogg')) {
                        fileBlock = `
                            <div class="mt-2">
                                <audio controls>
                                    <source src="${msg.file_path}" type="audio/webm">
                                </audio>
                            </div>
                        `;

                    } else {
                        fileBlock = `
                            <div class="mt-2">
                                <a href="${msg.file_path}" target="_blank">📎 просмотреть файл</a>
                            </div>
                        `;
                    }
                }
            }

            return `
                <li class="chat-item ${isAdmin ? 'odd' : ''} list-style-none mt-5 mb-5">
                    <div class="chat-content ${isAdmin ? 'text-right' : ''} d-inline-block pl-3">
                        <h6 class="font-weight-medium">${isAdmin ? 'Admin' : (msg.username ?? 'Client')}</h6>
                        ${fileBlock}

                        ${msg.text ? `
                        <div class="box msg p-2 d-inline-block mb-1 box" 
                            ${isAdmin ? 'style="background:#8274ff"' : 'style="background:#eef1f7"'}>
                            ${msg.text}
                        </div>` : ''}

                    </div>

                    <div class="chat-time text-muted ${isAdmin ? 'text-right' : ''} d-block font-10 ml-3" style="font-size: 0.6rem">
                        ${msg.created_at}
                    </div>
                </li>
            `;
        }

    </script>
@endpush