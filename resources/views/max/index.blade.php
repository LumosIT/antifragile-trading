<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Антихрупкий трейдинг</title>

<!-- Max Web App SDK -->
<script src="https://st.max.ru/js/max-web-app.js"></script>

<!-- Vue -->
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

@include('max.styles')

</head>

<body>

<!-- ===== Animated Background ===== -->
<div class="area">
    <ul class="circles">
        <li></li><li></li><li></li><li></li><li></li>
        <li></li><li></li><li></li><li></li><li></li>
    </ul>
</div>

<!-- ===== Vue App ===== -->
<div id="app" class="container d-flex align-items-center justify-content-center min-vh-100">
    <app-notification ref="notification"></app-notification>
    
    <!-- STEP 18 (PROFILE) -->
    <div v-if="isReady" v-cloak>
        <div v-if="step === 18">
            <carousel></carousel>

            <completed-form
                :user="user"
                :form-link="formLink"
                :following-enabled="following_enabled">
            </completed-form>

            <profile-block :max_chat="user.max_chat"></profile-block>

            <test-form
                :user="user"
                :link="testLink">
            </test-form>

            <support></support>

            <reset-steps></reset-steps>
        </div>
        <div v-else class="card shadow-lg p-4 w-100 d-flex flex-column mt-4 mb-4">
            <div class="flex-grow-1">

                <!-- STEP 1 -->
                <div v-if="step === 1">
                    <img 
                        :src="step === 1 ? '/storage/content/main.jpg' : ''" 
                        class="img-fluid mb-3"
                        loading="lazy">
                    {!! App\Services\ContentService::getContent('start_message') !!}
                </div>

                <!-- STEP 2 -->
                <div v-if="step === 2">
                    {!! App\Services\ContentService::getContent('conditions') !!}

                    <a href="https://antifragile-trading.ru/rules_club" target="_blank">Правила клуба</a>
                    <hr>
                    <a href="https://antifragile-trading.ru/rassilka" target="_blank">Согласие на рассылку</a>
                    <hr>
                    <a href="https://antifragile-trading.ru/confidencial" target="_blank">Политика конфиденциальности</a>
                </div>

                <!-- STEP 3 -->
                <div v-if="step === 3">
                    <video 
                        autoplay 
                        muted 
                        loop 
                        playsinline 
                        webkit-playsinline
                        style="max-width:100%; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.3);">
                        <source :src="step === 3 ? '/storage/content/rewards/3.mp4' : ''" type="video/mp4">
                        Ваш браузер не поддерживает видео.
                    </video>
                    {!! App\Services\ContentService::getContent('warm_reward_1', true) !!}
                </div>

                <!-- STEP 4 -->
                <div v-if="step === 4">
                    {!! App\Services\ContentService::getContent('welcome_message') !!}
                </div>

                <!-- STEP 5 -->
                <div v-if="step === 5">
                    <video    
                        autoplay 
                        muted 
                        loop 
                        playsinline 
                        webkit-playsinline
                        style="max-width:100%; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.3);">
                        <source :src="step === 5 ? '/storage/content/rewards/7.mp4' : ''" type="video/mp4">
                        Ваш браузер не поддерживает видео.
                    </video>
                    {!! App\Services\ContentService::getContent('warm_reward_2', true) !!}
                </div>

                <!-- STEP 6 -->
                <div v-if="step === 6">
                    {!! App\Services\ContentService::getContent('check_list') !!}
                    <a href="{{ asset('storage/content/Чек - лист как стать богатым.pdf') }}" target="_blank">
                        📄 Как стать богатым
                    </a>
                </div>

                <!-- STEP 7 -->
                <div v-if="step === 7">
                    {!! App\Services\ContentService::getContent('lecture_1_preview') !!}
                </div>

                <!-- STEP 8 -->
                <div v-if="step === 8">
                    <video
                        controls
                        playsinline
                        webkit-playsinline
                        style="max-width:100%; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.3);">
                        <source :src="step === 8 ? 'https://petr-petr.ru/storage/content/lectures/IMG_7407.MP4' : ''" type="video/mp4">
                        Ваш браузер не поддерживает видео.
                    </video>
                    {!! App\Services\ContentService::getContent('lecture_1_content') !!}
                </div>

                <!-- STEP 9 -->
                <div v-if="step === 9">
                    {!! App\Services\ContentService::getContent('lecture_2_preview') !!}
                </div>

                <!-- STEP 10 -->
                <div v-if="step === 10">
                    <video controls
                        style="max-width:100%; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.3);">
                        <source :src="step === 10 ? 'https://petr-petr.ru/storage/content/lectures/IMG_7408.MP4' : ''" type="video/mp4">
                        Ваш браузер не поддерживает видео.
                    </video>
                    {!! App\Services\ContentService::getContent('lecture_2_content') !!}

                </div>
                
                <!-- STEP 11 -->
                <div v-if="step === 11">
                    <video 
                        autoplay 
                        muted 
                        loop 
                        playsinline 
                        webkit-playsinline
                        style="max-width:100%; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.3);">
                        <source :src="step === 11 ? '/storage/content/rewards/8.mp4' : ''" type="video/mp4">
                        Ваш браузер не поддерживает видео.
                    </video>
                    {!! App\Services\ContentService::getContent('warm_reward_4', true) !!}
                </div>

                <!-- STEP 12 -->    
                <div v-if="step === 12">
                    {!! App\Services\ContentService::getContent('advert') !!}
                </div>

                <!-- STEP 13 -->
                <div v-if="step === 13">

                    <div class="carousel">
                        <div class="carousel-inner">
                            <img 
                                v-if="step === 13" 
                                :src="casesImages[current]" 
                                class="clickable"
                                loading="lazy"
                                @click="openLightbox(casesImages, current)">
                        </div>
                    </div>

                    <div class="carousel-controls mb-3">
                        <button class="nav-btn" @click="prev('cases')">←</button>

                        <div class="counter">
                            @{{ current + 1 }}
                        </div>

                        <button class="nav-btn" @click="next('cases')">→</button>
                    </div>

                    {!! App\Services\ContentService::getContent('cases') !!}

                </div>

                <!-- LIGHTBOX -->
                <div v-if="showLightbox" class="lightbox" @click="closeImage">
                    <img :src="lightboxImages[lightboxIndex]" class="lightbox-img">
                </div>

                <!-- STEPS 14- -->
                <div v-if="step === 14">
                    {!! App\Services\ContentService::getContent('lecture_3_preview') !!}
                </div>

                <!-- STEP 15 -->
                <div v-if="step === 15">
                    <video controls
                        style="max-width:100%; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.3);">
                        <source :src="step === 15 ? 'https://petr-petr.ru/storage/content/lectures/IMG_7409.MP4' : ''" type="video/mp4">
                        Ваш браузер не поддерживает видео.
                    </video>
                    {!! App\Services\ContentService::getContent('lecture_3_content') !!}
                </div>

                <!-- STEP 16 -->
                <div v-if="step === 16">
                    <div class="carousel mt-4">
                        <div class="carousel-inner">
                            <img 
                                :src="bestsImages[currentBests]"
                                class="clickable"
                                @click="openLightbox(bestsImages, currentBests)">
                        </div>
                    </div>

                    <div class="carousel-controls mb-3">
                        <button class="nav-btn" @click="prev('bests')">←</button>

                        <div class="counter">
                            @{{ currentBests + 1 }} / @{{ bestsImages.length }}
                        </div>

                        <button class="nav-btn" @click="next('bests')">→</button>
                    </div>

                    {!! App\Services\ContentService::getContent('bests') !!}

                </div>

                <!-- STEP 17 -->
                <div v-if="step === 17">
                    {!! App\Services\ContentService::getContent('pre_registration_announcement') !!}
                </div>

                <!-- BUTTONS -->
                <div class="d-flex justify-content-between mt-4">

                    <button class="btn btn-outline-secondary"
                            @click="prevStep"
                            v-if="step > 1">
                        ← Назад
                    </button>

                    <div>
                        <button class="btn btn-primary ms-auto"
                            id="next-button"
                            @click="nextStep"
                            v-if="step < totalSteps">
                        @{{ buttonMessage }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div v-else class="text-center mt-5">
        <h2 style="color: white">Загрузка приложения...</h2>
    </div>
</div>
@include('max.scripts')
</body>
</html>
