<script>

let user = null;
let userSteps = {
    1: 'null',
    2: 'conditions',
    3: 'prewelcome',
    4: 'welcome',
    5: 'pre_check_list',
    6: 'check_list',
    7: 'preview_lecture_1',
    8: 'get_lecture_1',
    9: 'read_lecture_1',
    10: 'get_lecture_2',
    11: 'pre_read_lecture_2',
    12: 'read_lecture_2',
    13: 'cases',
    14: 'preview_lecture_3',
    15: 'get_lecture_3',
    16: 'read_lecture_3',
    17: 'end',
    18: 'profile',
};

// Функция для рендеринга ошибки
function renderError() {
    document.body.innerHTML = '';

    const message = document.createElement('h1');
    message.textContent = 'Invalid data';
    message.style.color = 'red';
    message.style.textAlign = 'center';
    message.style.marginTop = '20%';
    document.body.appendChild(message);

    throw new Error('Init data invalid');
}

// Функция для инициализации Vue приложения
function initVueApp(startStep = 1, user, data) {
    const { createApp } = Vue;

    const app = createApp({
        data() {
            return {
                isReady: false,
                user: user,
                formLink: data.link,
                testLink: data.testLink,
                following_enabled: data.following_enabled,
                step: startStep,
                totalSteps: 20,
                lightboxIndex: 0,
                current: 0,
                currentBests: 0,
                buttonMessage: 'Далее →',
                steps: userSteps,
                lightboxImages: [],
                casesImages: [
                    '/storage/content/cases/c11.jpg',
                    '/storage/content/cases/c25.jpg',
                    '/storage/content/cases/c33.jpg'
                ],
                bestsImages: [
                    '/storage/content/cases/c47.jpg',
                    '/storage/content/cases/c45.jpg',
                    '/storage/content/cases/c36.jpg'
                ],
                mediaLoaded: false,
                showLightbox: false,
            }
        },
        watch: {
            step(newStep) {
                if(newStep === 2) this.buttonMessage = 'Принимаю условия';
                else if(newStep === 4) this.buttonMessage = 'Получить материалы';
                else if(newStep === 7 || newStep === 9 || newStep === 14) this.buttonMessage = 'Получить лекцию';
                else if(newStep === 8 || newStep === 10 || newStep === 15) this.buttonMessage = 'Лекция просмотрена';
                else if(newStep === 13) this.buttonMessage = 'Хочу так же';
                else this.buttonMessage = 'Далее →';

                fetch("/max-set-step", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ step: this.steps[newStep], chat: user.max_chat })
                })
                .then(res => res.json())
                .then(data => {
                    this.user = data.user;
                });
            }
        },
        methods: {
            nextStep() { 
                if(this.step < this.totalSteps) this.step++;
            },
            prevStep() {
                 if(this.step > 1) this.step--; 
                },
            next(type) {
                if(type === 'cases') this.current = (this.current + 1) % this.casesImages.length;
                else this.currentBests = (this.currentBests + 1) % this.bestsImages.length;
            },
            prev(type) {
                if(type === 'cases') this.current = (this.current - 1 + this.casesImages.length) % this.casesImages.length;
                else this.currentBests = (this.currentBests - 1 + this.bestsImages.length) % this.bestsImages.length;
            },
            openLightbox(images, index) {
                this.lightboxImages = images;
                this.lightboxIndex = index;
                this.showLightbox = true;
                document.body.style.overflow = 'hidden';
            },
            closeImage() {
                this.showLightbox = false;
                document.body.style.overflow = 'auto';
            },
            onMediaLoaded() {
                this.mediaLoaded = true;
            }
        },
        mounted() {
            document.querySelectorAll('.need-colored').forEach((el, index) => {
                if (index % 2 === 0) {
                    el.classList.add('bg-dark', 'text-light');
                }
            });

            setTimeout(() => this.isReady = true, 750);
        }
    });

    app.component('carousel', {
        template: `
        <div class="card need-colored shadow-lg p-4 w-100 d-flex flex-column">
            <h1 class="text-center text-light">Презентация клуба</h1>
            <p class="text-center text-secondary">
                Доступ на 2 ступень закрытого клуба открывается 1 раз в 2 месяца
            </p>

            <div id="carouselExampleIndicators" class="bg-dark carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://petr-petr.ru/storage/content/presentation/photo_1_2025-10-28_22-57-37.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://petr-petr.ru/storage/content/presentation/photo_2_2025-10-28_22-57-37.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://petr-petr.ru/storage/content/presentation/photo_3_2025-10-28_22-57-37.jpg" class="d-block w-100" alt="...">
                    </div>
                        <div class="carousel-item">
                        <img src="https://petr-petr.ru/storage/content/presentation/photo_4_2025-10-28_22-57-37.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://petr-petr.ru/storage/content/presentation/photo_5_2025-10-28_22-57-37.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://petr-petr.ru/storage/content/presentation/photo_6_2025-10-28_22-57-37.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://petr-petr.ru/storage/content/presentation/photo_7_2025-10-28_22-57-37.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://petr-petr.ru/storage/content/presentation/photo_8_2025-10-28_22-57-37.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://petr-petr.ru/storage/content/presentation/photo_9_2025-10-28_22-57-37.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
                <div class="carousel-indicators custom-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="6" aria-label="Slide 7"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="7" aria-label="Slide 8"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="8" aria-label="Slide 9"></button>
                </div>

                <div class="carousel-controls text-center mt-3">
                    <button class="btn btn-outline-light me-2" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        ← Назад
                    </button>
                    <button class="btn btn-outline-light" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        Вперёд →
                    </button>
                </div>
            </div>
        </div>
        `
    });

    app.component('profile-block', {
        props: ['max_chat'],
        data() {
            return {
                profileHtml: '',
                refLink: '',
                loading: true,
                error: false,
                copied: false,
                tariff: false,
                activeSubscription: false,
                subscriptionLoading: false,
                showModal: false,
                modalHtml: '',
                showTariffModal: false,
                tariffModalHtml: '',
                tariffs: [],
            }
        },
        mounted() {
            this.loadProfile();
        },
        methods: {
            async loadProfile() {
                try {
                    const res = await fetch(`/max/get-profile?chat=${this.max_chat}`);
                    const data = await res.json();

                    this.profileHtml = data.profile + "<p>Баланс: " + data.balance + "</p><hr>" + data.tariff;
                    this.refLink = data.refLink;

                    if (data.tariff != '') {
                        this.tariff = true;
                    }

                    this.activeSubscription = data.activeSubscription;

                } catch (e) {
                    this.error = true;
                } finally {
                    this.loading = false;
                }
            },

            async copyLink() {
                try {
                    await navigator.clipboard.writeText(this.refLink);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                } catch (e) {
                    alert('Не удалось скопировать');
                }
            },

            async renewTariff() {
                try {
                    const response = await fetch(`/max/renew-tariff?chat=${this.max_chat}`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.showForm === true) {
                        this.modalHtml = `<p>${data.message}</p>`;
                        this.showModal = true;
                    } else {
                        this.tariffs = data.tariffs;
                        this.showTariffModal = true;
                    }

                } catch (e) {
                    console.error('Ошибка:', e);
                    alert('Ошибка продления');
                }
            },

            async toggleSubscription() {
                try {
                    this.subscriptionLoading = true;

                    const url = this.activeSubscription
                        ? `/max/disable-autopaiment?chat=${this.chat}`
                        : `/max/autopaiment?chat=${this.chat}`;

                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    });

                    const data = await res.json();

                    if (data.status) {
                        this.activeSubscription = !this.activeSubscription;
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }

                } catch (e) {
                    alert('Ошибка изменения автопродления');
                } finally {
                    this.subscriptionLoading = false;
                }
            },

            async payTariff(tariffId) {
                try {
                    const response = await fetch('/max/pay-tariff', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            tariff_id: tariffId,
                            user_id: this.$root.user.id,
                        })
                    });

                    if (!response.ok) throw new Error('Ошибка при создании заказа');

                    const paymentUrl = await response.text();
                    window.open(paymentUrl, '_blank');
                } catch (error) {
                    console.error(error);
                    alert('Не удалось перейти к оплате. Попробуйте позже.');
                }
            },

            goToForm() {
                window.open(this.$root.formLink, '_blank');
            },
        },

        template: `
            <div class="card shadow-lg p-4 need-colored">

                <div v-if="loading">Загрузка профиля...</div>
                <div v-else-if="error">Ошибка загрузки профиля</div>

                <div v-else>

                    <button class="btn btn-outline-light mt-2 mb-2" @click="copyLink">
                        📋 Скопировать реферальную ссылку
                    </button>

                    <div v-if="copied" class="text-success mt-2">
                        Ссылка скопирована!
                    </div>

                    <div v-html="profileHtml" style="white-space: pre-line;" class="mt-3"></div>

                    <div v-if="tariff" class="mt-4">

                        <button 
                            class="btn btn-sm w-100 mb-3 border-secondary text-light bg-transparent hover-dark"
                            @click="renewTariff">
                            🔄 Продлить тариф вручную
                        </button>

                        <div class="d-flex justify-content-between align-items-center px-3 py-2 rounded bg-dark-subtle">

                            <div>
                                <div class="text-dark">Автопродление</div>
                                <small class="text-muted">
                                    @{{ activeSubscription ? 'Включено' : 'Отключено' }}
                                </small>
                            </div>

                            <button
                                class="btn btn-sm"
                                :class="activeSubscription ? 'btn-light' : 'btn-outline-secondary'"
                                :disabled="subscriptionLoading"
                                @click="toggleSubscription">

                                <span v-if="subscriptionLoading">...</span>
                                <span v-else>
                                    @{{ activeSubscription ? 'Выключить' : 'Включить' }}
                                </span>

                            </button>

                        </div>

                    </div>
                </div>

            </div>

            <div v-if="showModal"
                class="modal fade show d-block"
                style="background: rgba(0,0,0,0.6);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-light border-secondary">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title">Заполните форму</h5>
                            <button 
                                type="button" 
                                class="btn-close btn-close-white"
                                @click="showModal = false">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-html="modalHtml"></div>
                        </div>
                        <div class="modal-footer border-secondary">
                            <button 
                                class="btn btn-outline-light"
                                @click="showModal = false">
                                Отмена
                            </button>
                            <button 
                                class="btn btn-light"
                                @click="goToForm">
                                Заполнить форму
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div v-if="showTariffModal"
                class="modal fade show d-block"
                style="background: rgba(0,0,0,0.6);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-light border-secondary">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title">Выберите тариф</h5>
                            <button type="button" 
                                    class="btn-close btn-close-white"
                                    @click="showTariffModal = false">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-for="tariff in tariffs" :key="tariff.id" 
                                style="background: #fff; border: 1px solid #e2e8f0; 
                                        border-radius: 12px; padding: 16px; margin-bottom: 12px; 
                                        display: flex; justify-content: space-between; 
                                        align-items: center; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                                <div>
                                    <div style="font-weight: 600; font-size: 16px; margin-bottom: 4px; color:black">
                                        @{{ tariff.name }}
                                    </div>
                                    <div style="color: #4a5568;">
                                        Цена: <strong>@{{ tariff.price.toLocaleString() }} руб</strong>
                                    </div>
                                    <div style="color: #4a5568;">
                                        Длительность: <strong>@{{ tariff.duration }} дней</strong>
                                    </div>
                                </div>
                                <button style="background: #2563eb; color: #fff; padding: 8px 14px; 
                                            border-radius: 6px; font-weight: 500; border: none; cursor: pointer;"
                                        @click="payTariff(tariff.id)">
                                    Оплатить
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer border-secondary">
                            <button class="btn btn-outline-light" @click="showTariffModal = false">
                                Отмена
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `
    });

    app.component('completed-form', {
        props: ['user', 'formLink', 'followingEnabled'],
        data() {
            return {
                showTariffModal: false,
                tariffs: []
            }
        },
        template: `
            <div v-if="followingEnabled" class="card need-colored shadow-lg p-4 w-100 d-flex flex-column">
                <h1 class="text-center">Набор в клуб 257 открыт</h1>
                <button class="btn btn-success" @click="renewTariff()">Выбрать тариф</button>
            </div>
            <div v-else class="card need-colored shadow-lg p-4 w-100 d-flex flex-column">

                <template v-if="user && user.meta_is_pre_form_filled">
                    <h1 class="text-center">Форма успешно заполнена</h1>
                    <p>Спасибо за заполнение формы, мы свяжемся с вами в ближайшее время.</p>
                </template>

                <template v-else>
                    <h1 class="text-center">Форма не заполнена</h1>
                    <p>Пожалуйста, заполните форму, чтобы мы могли связаться с вами.</p>
                    <a class="btn btn-outline-dark" :href="formLink" target="_blank">Заполнить форму</a>
                </template>
            </div>

            <div v-if="showTariffModal"
                class="modal fade show d-block"
                style="background: rgba(0,0,0,0.6);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-light border-secondary">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title">Выберите тариф</h5>
                            <button type="button" 
                                    class="btn-close btn-close-white"
                                    @click="showTariffModal = false">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-for="tariff in tariffs" :key="tariff.id" 
                                style="background: #fff; border: 1px solid #e2e8f0; 
                                        border-radius: 12px; padding: 16px; margin-bottom: 12px; 
                                        display: flex; justify-content: space-between; 
                                        align-items: center; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                                <div>
                                    <div style="font-weight: 600; font-size: 16px; margin-bottom: 4px; color:black">
                                        @{{ tariff.name }}
                                    </div>
                                    <div style="color: #4a5568;">
                                        Цена: <strong>@{{ tariff.price.toLocaleString() }} руб</strong>
                                    </div>
                                    <div style="color: #4a5568;">
                                        Длительность: <strong>@{{ tariff.duration }} дней</strong>
                                    </div>
                                </div>
                                <button style="background: #2563eb; color: #fff; padding: 8px 14px; 
                                            border-radius: 6px; font-weight: 500; border: none; cursor: pointer;"
                                        @click="payTariff(tariff.id)">
                                    Оплатить
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer border-secondary">
                            <button class="btn btn-outline-light" @click="showTariffModal = false">
                                Отмена
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `,
        methods: {
            async renewTariff() {
                try {
                    const response = await fetch(`/max/renew-tariff?chat=${this.user.max_chat}`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();

                    this.showTariffModal = true;
                    this.tariffs = data.tariffs;

                    console.log(data);
                } catch (e) {
                    console.error('Ошибка:', e);
                    alert('Ошибка продления');
                }
            },

            async payTariff(tariffId) {
                try {
                    const response = await fetch('/max/pay-tariff', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            tariff_id: tariffId,
                            user_id: this.user.id,
                        })
                    });

                    if (!response.ok) throw new Error('Ошибка при создании заказа');

                    const paymentUrl = await response.text();
                    window.open(paymentUrl, '_blank');
                } catch (error) {
                    console.error(error);
                    alert('Не удалось перейти к оплате. Попробуйте позже.');
                }
            },
        }
    });

    app.component('support', {
        template: `
        <div class="card need-colored shadow-lg p-4 w-100 d-flex flex-column">
            <h1 class="text-center">Поддержка</h1>
            <p>Если у вас возникли вопросы, пожалуйста, свяжитесь с нашей поддержкой:</p>
            <a href="https://t.me/club257_supportbot" target="_blank">Телеграм-бот поддержки</a>
        </div>
        `
    });

    app.component('reset-steps', {
        template: `
            <div class="card need-colored shadow-lg p-4 w-100 d-flex flex-column">
                <p class="text-center">Пройти вступительное обучение ещё раз</p>
                
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#resetModal">
                    Начать сначала
                </button>

                <!-- Modal -->
                <div class="modal fade" id="resetModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header border-secondary">
                                <h5 class="modal-title">Подтверждение</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Вы уверены, что хотите начать обучение заново?<br>
                                <small class="text-warning">Прогресс будет полностью сброшен.</small>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Отмена
                                </button>
                                <button type="button" class="btn btn-danger" @click="confirmReset">
                                    Да, начать
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `,
        methods: {
            confirmReset() {
                this.$root.step = 1;

                // закрываем модалку вручную
                const modalEl = document.getElementById('resetModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
            }
        }
    });

    app.component('test-form', {
        props: ['user', 'testLink'],
        template: `
            <div class="card need-colored shadow-lg p-4 w-100 d-flex flex-column" v-if="user && user.invite_in_test">
                <div class="text-center">

                    <h3 class="mb-3">🎯 Доступ к тесту открыт</h3>

                    <p class="mb-2">
                        Вам доступен специальный тест, успешное прохождение которого откроет возможность перейти на <strong>3-ю ступень</strong>.
                    </p>

                    <p class="mb-2">
                        У вас есть только <strong>одна попытка</strong>, которая предоставляется раз в <strong>30 дней</strong>.
                    </p>

                    <p class="mb-0 text-muted">
                        Обратите внимание: тест отличается высокой сложностью.
                    </p>

                    <a :href="testLink" class="btn btn-success mt-3" target="_blank">
                        Начать тестирование
                    </a>
                </div>
            </div>
        `
    })

    app.mount("#app");
}

// Проверка initData сразу при загрузке
window.onload = function () {
    if (!window.WebApp) return renderError();

    const initData = window.WebApp.initData;

    fetch("/max-init", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ initData: initData })
    })
    .then(res => res.json())
    .then(data => {
        const isValid = data.valid === true;

        if (!isValid) return renderError();

        user = data.user || null;

        let initialStep = 1;

        if (user && user.start_key) {
            for (const [key, value] of Object.entries(userSteps)) {
                if (value === user.start_key) {
                    initialStep = parseInt(key);
                    break;
                }
            }
        }

        initVueApp(initialStep, user, data);
    });
};
</script>