@extends('layouts.landing')

@section('title', 'Photobooth · Ambil Foto')

@section('content')
<style>
    body { height: 100vh; height: 100dvh; min-height: 0; overflow: hidden; }
    body > main { min-height: 0; overflow: hidden; align-items: stretch; }
    #booth-page { height: 100%; min-height: 0; padding-top: .5rem; padding-bottom: .5rem; display: flex; flex-direction: column; }
    #booth-card { flex: 1; min-height: 0; overflow: visible; grid-template-columns: minmax(0, 1fr) 270px; grid-template-rows: minmax(0, 1fr); gap: 1rem; padding: 1.5rem; }
    #preview-heading { margin-bottom: 1rem; padding: .25rem .5rem; }
    #status { margin-top: 1rem; padding: 0 .75rem; line-height: 1.5rem; }
    #preview-column { min-height: 0; display: flex; flex-direction: column; }
    #booth-preview { height: min(76dvh, 900px); max-height: calc(100dvh - 340px); width: auto; max-width: 100%; }
    #camera { transform: none !important; -webkit-transform: none !important; }
    #guide-actions { min-height: 0; }
    @media (max-width: 767px) {
        body { height: auto; min-height: 100dvh; overflow-x: hidden; overflow-y: auto; }
        body > main { flex: 1 0 auto; overflow: visible; }
        #booth-page { height: auto; min-height: calc(100dvh - 140px); padding-left: .5rem; padding-right: .5rem; }
        #booth-card { display: grid; flex: none; min-height: 0; grid-template-columns: minmax(0, 1fr); grid-template-rows: auto auto; gap: .75rem; padding: 1rem; }
        #preview-column { justify-content: flex-start; }
        #booth-preview { height: min(48dvh, 440px); max-height: none; }
        #guide-actions { display: grid; grid-template-columns: minmax(0, .85fr) minmax(0, 1fr); gap: .5rem; }
        #instructions, #action-panel { padding: .6rem; }
        #instructions ol { font-size: .7rem; line-height: 1rem; }
        #instructions p { display: none; }
        #action-hint { margin-bottom: .4rem; font-size: .75rem; }
        #capture-button, #retake-button, #continue-button { padding-top: .55rem; padding-bottom: .55rem; font-size: .8rem; }
    }
</style>
<section id="booth-page" class="w-full max-w-6xl mx-auto px-4 text-left">
    <div class="flex items-center justify-between mb-2 flex-none">
        <a href="{{ route('photobooth.index') }}" class="text-sm text-pink-700 hover:underline">← Pilih frame lain</a>
        <span class="text-sm text-gray-600">{{ $frame->name }} · {{ $frame->shot_count }} foto</span>
    </div>

    <div id="booth-card" class="bg-white rounded-2xl shadow-lg p-3 md:p-4 grid items-center">
        <div id="preview-column">
            <div id="preview-heading" class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Photobooth</h1>
                    <p id="capture-progress" class="text-sm text-gray-500">0 / {{ $frame->shot_count }}</p>
                </div>
                <p id="active-slot-label" class="text-sm font-medium text-pink-700">Slot 1 aktif</p>
            </div>

            <div id="booth-preview" class="relative mx-auto overflow-hidden rounded-xl bg-gray-900 shadow-md" style="aspect-ratio:{{ $frame->width }}/{{ $frame->height }}">
                <div id="photo-slots" class="absolute inset-0 z-10"></div>
                <img src="{{ asset('storage/'.$frame->image_path) }}" alt="Frame {{ $frame->name }}" class="absolute inset-0 z-20 h-full w-full object-fill pointer-events-none">
                <div id="active-highlight" class="absolute z-30 border-4 border-yellow-300 pointer-events-none transition-all duration-200"></div>
                <div id="countdown" class="hidden absolute inset-0 z-40 flex items-center justify-center bg-black bg-opacity-30 text-white text-7xl md:text-8xl font-bold">3</div>
            </div>
            <p id="status" role="status" aria-live="polite" class="mt-2 min-h-5 text-center text-sm text-gray-600 flex-none">Klik “Deteksi & Izinkan Kamera”. Browser menampilkan pop-up jika izin belum pernah dipilih.</p>
        </div>

        <aside id="guide-actions" class="flex flex-col gap-3">
            <div id="instructions" class="rounded-xl bg-pink-50 p-3">
                <h2 class="font-semibold text-gray-800 mb-2 text-sm">Panduan cepat</h2>
                <ol class="space-y-1 text-sm text-gray-700">
                    <li><span class="font-semibold text-pink-700">1.</span> Bersiap di depan kamera.</li>
                    <li><span class="font-semibold text-pink-700">2.</span> Cekrek pada slot aktif.</li>
                    <li><span class="font-semibold text-pink-700">3.</span> Retake atau lanjut.</li>
                </ol>
                <p class="mt-2 text-xs text-gray-500">Klik slot mana pun untuk memilihnya.</p>
            </div>
            <div id="action-panel" class="rounded-xl border border-gray-200 p-3">
                <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Aksi slot aktif</p>
                <p id="action-hint" class="text-sm text-gray-700 mb-3">Bersiap untuk Slot 1.</p>
                <div class="flex flex-col gap-2">
                    <button id="enable-camera-button" type="button" class="w-full rounded-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-3 px-4">Deteksi & Izinkan Kamera</button>
                    <button id="capture-button" type="button" disabled class="w-full rounded-full bg-pink-500 hover:bg-pink-600 disabled:opacity-50 text-white font-semibold py-3 px-4">Cekrek · Slot 1</button>
                    <button id="retake-button" type="button" class="hidden w-full rounded-full border border-pink-300 text-pink-700 hover:bg-pink-50 font-medium py-2 px-4">Foto Ulang Slot Ini</button>
                    <button id="continue-button" type="button" class="hidden w-full rounded-full bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4">Lanjut</button>
                </div>
            </div>
        </aside>
    </div>
</section>

<div id="result-modal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-70 p-4 items-center justify-center" role="dialog" aria-modal="true" aria-labelledby="result-title" aria-hidden="true">
    <section class="relative w-full max-w-xl max-h-full overflow-y-auto rounded-2xl bg-white p-5 md:p-6 text-center shadow-2xl">
        <h2 id="result-title" class="text-xl font-bold mb-1">Hasil photostrip</h2>
        <p class="text-sm text-gray-500 mb-4">Foto kamu siap diunduh.</p>
        <canvas id="final-canvas" style="max-height:60vh" class="block w-auto max-w-full mx-auto rounded-lg shadow"></canvas>
        <div class="mt-5 flex flex-col sm:flex-row justify-center gap-3">
            <a id="download-button" class="rounded-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 px-6">Unduh Foto</a>
            <button id="photo-again-button" type="button" class="rounded-full border border-gray-300 hover:bg-gray-50 py-3 px-6">Foto Lagi</button>
            <a href="{{ route('photobooth.index') }}" class="rounded-full border border-gray-300 hover:bg-gray-50 py-3 px-6">Kembali</a>
        </div>
    </section>
</div>
<video id="camera" autoplay playsinline muted class="hidden"></video>
@endsection

@section('scripts')
<script type="module">
import { getPhotoBoothLayout, renderPhotoBooth } from @json(asset('js/photobooth-renderer.js'));

(() => {
    const video = document.getElementById('camera');
    const frame = new Image();
    frame.src = @json(asset('storage/'.$frame->image_path));
    const width = @json((int) $frame->width);
    const height = @json((int) $frame->height);
    const photoCount = @json((int) $frame->shot_count);
    const captureButton = document.getElementById('capture-button');
    const enableCameraButton = document.getElementById('enable-camera-button');
    const retakeButton = document.getElementById('retake-button');
    const continueButton = document.getElementById('continue-button');
    const status = document.getElementById('status');
    const actionHint = document.getElementById('action-hint');
    const countdown = document.getElementById('countdown');
    const activeHighlight = document.getElementById('active-highlight');
    const resultModal = document.getElementById('result-modal');
    const finalCanvas = document.getElementById('final-canvas');
    const slotPreview = document.getElementById('photo-slots');
    const layout = getPhotoBoothLayout(photoCount, width, height);
    const capturedPhotos = Array(photoCount).fill(null);
    const slotButtons = [];

    /* ── State Variables ─────────────────────────────────────── */
    let currentActiveSlot = 0;      // Which slot is currently targeted
    let stream = null;              // Camera MediaStream
    let countdownTimer = null;      // Active setTimeout reference
    let countdownRun = 0;           // Generation counter — invalidates stale callbacks
    let isCapturing = false;        // Lock: true while countdown→capture is in progress
    let countdownRunning = false;   // True while 3→2→1 is actively ticking
    let isRetakeMode = false;       // True when current flow originated from a retake action
    let pendingConfirmation = false;// True after capture, waiting for Retake / Continue
    let captureReady = true;        // True = show Cekrek; False = show Retake/Continue

    /* ── GLOBAL RESET: Fungsi sentral untuk membuka semua kunci ── */
    function resetCaptureState() {
        isCapturing = false;
        countdownRunning = false;
        // Selalu pastikan tombol Cekrek tidak terkunci oleh atribut disabled
        // (updateUI akan mengatur ulang berdasarkan cameraReady,
        //  tapi kita perlu baseline yang bersih)
        captureButton.removeAttribute('disabled');
    }

    /* ── Build Slot Buttons ──────────────────────────────────── */
    layout.slots.forEach((slot, index) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'absolute overflow-hidden border-2 border-dashed border-white bg-gray-700 bg-opacity-70 text-white text-xs font-semibold';
        button.style.left = `${slot.x / width * 100}%`;
        button.style.top = `${slot.y / height * 100}%`;
        button.style.width = `${slot.width / width * 100}%`;
        button.style.height = `${slot.height / height * 100}%`;
        button.addEventListener('click', () => selectSlot(index));
        slotPreview.appendChild(button);
        slotButtons.push(button);
    });

    /* ── Update Individual Slot Visual ───────────────────────── */
    function updateSlot(index) {
        const button = slotButtons[index];

        // CRITICAL FIX: Sebelum replaceChildren(), keluarkan <video> dari
        // slot MANAPUN agar tidak ikut terhapus dari DOM secara permanen.
        // Video yang terlepas dari DOM bisa menyebabkan video.videoWidth = 0
        // sehingga cameraReady = false dan tombol Cekrek terkunci.
        if (video.parentElement === button) {
            button.removeChild(video);
        }

        button.replaceChildren();

        // Show live camera feed in the active slot when:
        // - captureReady: user is positioning for a new photo / retake
        // - isCapturing: countdown is running, keep showing live feed
        const showLivePreview = index === currentActiveSlot
            && stream
            && (captureReady || isCapturing);

        if (showLivePreview) {
            video.className = 'absolute inset-0 h-full w-full object-cover';
            video.style.transform = 'none';
            video.style.webkitTransform = 'none';
            button.appendChild(video);
        } else if (capturedPhotos[index]) {
            const image = document.createElement('img');
            image.src = capturedPhotos[index].toDataURL('image/jpeg', 0.85);
            image.alt = `Foto pada Slot ${index + 1}`;
            image.className = 'absolute inset-0 h-full w-full object-cover';
            button.appendChild(image);
        } else {
            const placeholder = document.createElement('span');
            placeholder.className = 'absolute inset-0 flex items-center justify-center';
            placeholder.textContent = `Slot ${index + 1}`;
            button.appendChild(placeholder);
        }

        const badge = document.createElement('span');
        badge.className = 'absolute bottom-1 left-1 rounded bg-black bg-opacity-60 px-2 py-1 text-xs text-white';
        badge.textContent = capturedPhotos[index] ? '✓' : `${index + 1}`;
        button.appendChild(badge);
        button.classList.toggle('ring-4', index === currentActiveSlot);
        button.classList.toggle('ring-yellow-300', index === currentActiveSlot);
        button.classList.toggle('border-yellow-300', index === currentActiveSlot);
        button.classList.toggle('border-green-300', Boolean(capturedPhotos[index]) && index !== currentActiveSlot);
        button.setAttribute('aria-label', `Pilih Slot ${index + 1}${capturedPhotos[index] ? ', foto sudah terisi' : ', masih kosong'}`);
    }

    /* ── Check Camera Readiness (toleran terhadap video detached) ── */
    function isCameraReady() {
        if (!stream) return false;
        if (!stream.getTracks().some(track => track.readyState === 'live')) return false;
        // video.videoWidth bisa = 0 sesaat setelah video dipindah antar slot.
        // Kalau stream aktif, anggap kamera siap — videoWidth akan pulih
        // di frame berikutnya.
        return true;
    }

    /* ── Update All UI Elements ───────────────────────────────── */
    function updateUI() {
        layout.slots.forEach((_, index) => updateSlot(index));
        const activeSlot = layout.slots[currentActiveSlot];
        activeHighlight.style.left = `${activeSlot.x / width * 100}%`;
        activeHighlight.style.top = `${activeSlot.y / height * 100}%`;
        activeHighlight.style.width = `${activeSlot.width / width * 100}%`;
        activeHighlight.style.height = `${activeSlot.height / height * 100}%`;
        const completed = capturedPhotos.filter(Boolean).length;
        document.getElementById('capture-progress').textContent = `${completed} / ${photoCount}`;
        document.getElementById('active-slot-label').textContent = `Slot ${currentActiveSlot + 1} aktif`;
        captureButton.textContent = `Cekrek · Slot ${currentActiveSlot + 1}`;

        const hasActivePhoto = Boolean(capturedPhotos[currentActiveSlot]);
        const canConfirm = pendingConfirmation || (hasActivePhoto && !captureReady);
        const cameraReady = isCameraReady();

        captureButton.classList.toggle('hidden', canConfirm);
        retakeButton.classList.toggle('hidden', !canConfirm);
        continueButton.classList.toggle('hidden', !canConfirm);

        // Tombol Cekrek: aktif jika kamera siap DAN tidak sedang countdown/capture
        captureButton.disabled = !cameraReady || isCapturing || countdownRunning;
        // Retake & Continue: tidak bergantung pada cameraReady karena
        // saat pendingConfirmation video memang tidak di-attach ke slot
        retakeButton.disabled = isCapturing || countdownRunning;
        continueButton.disabled = isCapturing || countdownRunning;

        if (canConfirm) {
            retakeButton.textContent = `Foto Ulang Slot ${currentActiveSlot + 1}`;
            const nextSlot = (currentActiveSlot + 1) % photoCount;
            continueButton.textContent = capturedPhotos.every(Boolean)
                ? 'Lihat Hasil'
                : `Lanjut Cekrek · Slot ${nextSlot + 1}`;
        } else {
            actionHint.textContent = `Bersiap untuk Slot ${currentActiveSlot + 1}.`;
        }
        actionHint.classList.toggle('hidden', canConfirm);
    }

    /* ── Camera Management ───────────────────────────────────── */
    async function startCamera() {
        if (!window.isSecureContext) {
            status.textContent = 'Browser tidak akan menampilkan izin kamera untuk koneksi ini. Buka URL HTTPS ngrok (bukan HTTP), atau localhost.';
            enableCameraButton.disabled = false;
            enableCameraButton.textContent = 'Coba Lagi';
            return;
        }

        if (!navigator.mediaDevices || typeof navigator.mediaDevices.getUserMedia !== 'function') {
            status.textContent = 'Fitur kamera tidak tersedia. Buka URL ngrok HTTPS langsung di tab browser, bukan di dalam preview aplikasi lain.';
            enableCameraButton.disabled = false;
            enableCameraButton.textContent = 'Coba Lagi';
            return;
        }

        const cameraPolicy = document.permissionsPolicy || document.featurePolicy;
        if (cameraPolicy && typeof cameraPolicy.allowsFeature === 'function' && !cameraPolicy.allowsFeature('camera')) {
            status.textContent = 'Akses kamera diblokir oleh kebijakan halaman/iframe. Buka URL ngrok langsung di tab browser.';
            enableCameraButton.disabled = false;
            enableCameraButton.textContent = 'Coba Lagi';
            return;
        }

        enableCameraButton.disabled = true;
        enableCameraButton.textContent = 'Mengecek kamera…';
        status.textContent = 'Sedang meminta akses kamera. Perhatikan pop-up izin di dekat bilah alamat browser.';
        try {
            if (!stream || stream.getTracks().every(track => track.readyState === 'ended')) {
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false });
            }
            video.srcObject = stream;
            await video.play();
            enableCameraButton.classList.add('hidden');
            status.textContent = `Kamera terdeteksi dan izin aktif. Preview mengikuti Slot ${currentActiveSlot + 1}.`;
            resetCaptureState();
            updateUI();
        } catch (error) {
            console.error(error);
            enableCameraButton.disabled = false;
            enableCameraButton.textContent = 'Minta Izin Kamera Lagi';
            enableCameraButton.classList.remove('hidden');
            if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                let permissionState = 'unknown';
                try {
                    permissionState = (await navigator.permissions.query({ name: 'camera' })).state;
                } catch (_) {
                    // Permissions API tidak tersedia di semua browser.
                }
                status.textContent = permissionState === 'denied'
                    ? 'Izin kamera situs sedang diblokir, jadi browser tidak menampilkan pop-up. Klik ikon gembok di bilah alamat → Izin Situs → Kamera → Izinkan, lalu muat ulang halaman.'
                    : 'Permintaan izin kamera ditolak. Pilih Izinkan pada pop-up. Jika pop-up tidak muncul, ubah izin Kamera situs dari ikon gembok di bilah alamat, lalu muat ulang.';
            } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                status.textContent = 'Kamera tidak terdeteksi di perangkat. Sambungkan kamera atau pilih kamera yang tersedia, lalu coba lagi.';
            } else {
                status.textContent = `Kamera belum dapat diakses (${error.name || 'error'}). Pastikan kamera tersedia dan tidak sedang dipakai aplikasi lain, lalu coba lagi.`;
            }
            captureButton.disabled = true;
        }
    }

    /**
     * Re-attach dan restart live camera stream pada slot aktif.
     * Menunggu hingga video benar-benar punya frame (videoWidth > 0)
     * sebelum mengupdate UI, agar cameraReady tidak false saat
     * tombol Cekrek di-render.
     */
    async function reattachCameraStream() {
        if (!stream) return;
        video.srcObject = stream;
        try {
            await video.play();
        } catch (_) {
            // play() bisa gagal jika user belum berinteraksi — abaikan
        }
        // Tunggu sampai video punya frame (max ~500ms safety timeout)
        if (!video.videoWidth) {
            await new Promise(resolve => {
                const onFrame = () => { resolve(); };
                // 'loadeddata' fires when the first frame is available
                video.addEventListener('loadeddata', onFrame, { once: true });
                // Safety timeout agar tidak menggantung selamanya
                setTimeout(() => {
                    video.removeEventListener('loadeddata', onFrame);
                    resolve();
                }, 500);
            });
        }
    }

    /* ── Slot Selection ──────────────────────────────────────── */
    function selectSlot(index) {
        // IMMEDIATELY clear any running countdown/timer when a slot
        // button is clicked — prevents stale auto-capture from firing.
        clearCountdown();

        currentActiveSlot = index;
        pendingConfirmation = false;
        captureReady = !capturedPhotos[index];
        isRetakeMode = false;

        // Re-attach camera for fresh live feed on selected slot, then update UI
        reattachCameraStream().then(() => {
            resetCaptureState();
            updateUI();
        });

        // Immediate visual feedback sebelum await selesai
        updateUI();
        status.textContent = capturedPhotos[index]
            ? `Slot ${index + 1} dipilih. Pilih Foto Ulang atau Lanjut.`
            : `Slot ${index + 1} dipilih untuk foto berikutnya.`;
    }

    /* ── Countdown Management ────────────────────────────────── */
    function clearCountdown() {
        countdownRun += 1;
        if (countdownTimer !== null) {
            clearInterval(countdownTimer);
            clearTimeout(countdownTimer);
            countdownTimer = null;
        }
        // Reset ALL state flags on clear
        isCapturing = false;
        countdownRunning = false;
        countdown.classList.add('hidden');
    }

    function startCountdown(mode = 'normal', targetIndex = currentActiveSlot) {
        // Invalidate any previous countdown before arming a new one
        clearCountdown();

        // Gunakan isCameraReady() — toleran terhadap video.videoWidth sesaat = 0
        if (!isCameraReady() || targetIndex < 0 || targetIndex >= photoCount) return;

        currentActiveSlot = targetIndex;
        isCapturing = true;
        countdownRunning = true;
        captureReady = false;
        pendingConfirmation = false;
        const run = countdownRun;
        let seconds = 3;
        countdown.textContent = seconds;
        countdown.classList.remove('hidden');
        status.textContent = `Bersiap... foto Slot ${targetIndex + 1} dalam ${seconds}.`;
        updateUI();

        const tick = () => {
            // Guard: abort if this countdown was invalidated by clearCountdown()
            if (run !== countdownRun || !isCapturing) return;
            seconds -= 1;
            countdown.textContent = Math.max(seconds, 0);
            if (seconds > 0) {
                status.textContent = `Bersiap... foto Slot ${targetIndex + 1} dalam ${seconds}.`;
                countdownTimer = setTimeout(tick, 1000);
                return;
            }

            // Capture ONLY happens after countdown completes 3→2→1→0
            countdownTimer = null;
            countdownRunning = false;
            countdown.classList.add('hidden');
            captureActiveSlot(targetIndex, mode, run);
        };

        countdownTimer = setTimeout(tick, 1000);
    }

    /* ── Capture Logic ───────────────────────────────────────── */
    function captureActiveSlot(targetIndex, mode, run) {
        // Guard: verify this capture request is still valid
        if (run !== countdownRun || !isCapturing) return;
        if (!video.videoWidth || !video.videoHeight) {
            clearCountdown();
            resetCaptureState();
            status.textContent = 'Kamera belum siap. Tunggu sebentar lalu coba lagi.';
            updateUI();
            return;
        }

        const photo = document.createElement('canvas');
        photo.width = video.videoWidth;
        photo.height = video.videoHeight;
        const context = photo.getContext('2d');
        if (!context) {
            clearCountdown();
            resetCaptureState();
            status.textContent = 'Foto gagal diproses. Silakan coba lagi.';
            updateUI();
            return;
        }
        context.drawImage(video, 0, 0, photo.width, photo.height);

        // Replace ONLY capturedPhotos[targetIndex] — all other slots untouched
        capturedPhotos[targetIndex] = photo;
        pendingConfirmation = true;
        captureReady = false;
        currentActiveSlot = targetIndex;

        // ★ KUNCI FIX: Reset semua flag capture SETELAH foto diambil
        // agar tombol Retake/Continue LANGSUNG aktif & siap diklik
        isCapturing = false;
        countdownRunning = false;
        countdownTimer = null;
        resetCaptureState();

        updateUI();
        status.textContent = mode === 'retake'
            ? `Slot ${targetIndex + 1} diperbarui. Lanjutkan atau retake lagi.`
            : `Foto Slot ${targetIndex + 1} berhasil diambil.`;
        if (mode === 'retake' && capturedPhotos.every(Boolean)) {
            renderLatestPhotostrip().catch(error => {
                console.error(error);
                status.textContent = 'Preview hasil belum dapat diperbarui. Foto slot tetap tersimpan.';
            });
        }
    }

    /* ── Photostrip Rendering ────────────────────────────────── */
    async function renderLatestPhotostrip() {
        if (capturedPhotos.some(photo => !photo)) return;
        if (!frame.complete) {
            await new Promise((resolve, reject) => {
                frame.onload = resolve;
                frame.onerror = () => reject(new Error('Frame overlay gagal dimuat.'));
            });
        }

        renderPhotoBooth(finalCanvas, capturedPhotos, frame, photoCount, { width, height });
    }

    async function generatePhotostrip() {
        if (capturedPhotos.some(photo => !photo)) return;
        await renderLatestPhotostrip();
        const downloadButton = document.getElementById('download-button');
        downloadButton.href = finalCanvas.toDataURL('image/png');
        downloadButton.download = `photostrip-${photoCount}-foto.png`;
        resultModal.classList.remove('hidden');
        resultModal.classList.add('flex');
        resultModal.setAttribute('aria-hidden', 'false');
        status.textContent = 'Photostrip selesai.';
        if (stream) stream.getTracks().forEach(track => track.stop());
        updateUI();
    }

    /* ── Continue / Advance ──────────────────────────────────── */
    function advanceToNextSlot() {
        const activePhotoIsConfirmed = Boolean(capturedPhotos[currentActiveSlot]) && !captureReady;
        if (capturedPhotos.every(Boolean) && activePhotoIsConfirmed) {
            generatePhotostrip().catch(error => {
                console.error(error);
                status.textContent = 'Photostrip gagal dibuat. Periksa file frame lalu coba lagi.';
            });
            return;
        }

        // Clear any lingering timers before advancing
        clearCountdown();
        pendingConfirmation = false;
        isRetakeMode = false;
        currentActiveSlot = (currentActiveSlot + 1) % photoCount;

        captureReady = true;

        // Re-attach camera stream, tunggu frame, lalu update UI & unlock button
        reattachCameraStream().then(() => {
            resetCaptureState();
            updateUI();
        });

        // Immediate visual feedback
        resetCaptureState();
        updateUI();
        status.textContent = `Lanjut ke Slot ${currentActiveSlot + 1}. Bersiap untuk pose berikutnya.`;
    }

    /* ── Retake ──────────────────────────────────────────────── */
    function retakeCurrentSlot() {
        const targetIndex = currentActiveSlot;

        // IMMEDIATELY stop & reset ALL timers/countdowns
        clearCountdown();

        // Clear ONLY this slot's photo — other slots untouched
        capturedPhotos[targetIndex] = null;

        currentActiveSlot = targetIndex;
        captureReady = true;            // Show Cekrek button — do NOT auto-capture!
        pendingConfirmation = false;
        isRetakeMode = true;            // Remember this is a retake flow

        // Re-attach camera stream, tunggu frame, lalu update UI & unlock button
        reattachCameraStream().then(() => {
            resetCaptureState();
            updateUI();
        });

        // Immediate visual feedback
        resetCaptureState();
        updateUI();
        status.textContent = `Mode foto ulang Slot ${targetIndex + 1}. Tekan Cekrek jika sudah siap.`;
    }

    /* ── Start Again ─────────────────────────────────────────── */
    function startAgain() {
        clearCountdown();
        capturedPhotos.fill(null);
        currentActiveSlot = 0;
        captureReady = true;
        pendingConfirmation = false;
        isRetakeMode = false;
        resultModal.classList.add('hidden');
        resultModal.classList.remove('flex');
        resultModal.setAttribute('aria-hidden', 'true');
        resetCaptureState();
        startCamera();
        updateUI();
        status.textContent = 'Foto baru dimulai. Bersiap untuk Slot 1.';
    }

    /* ── Event Listeners (Permanent — tidak pernah di-detach) ── */
    captureButton.addEventListener('click', () => {
        // Block if countdown or capture is already in progress
        if (countdownRunning || isCapturing) return;
        startCountdown(isRetakeMode ? 'retake' : 'normal', currentActiveSlot);
    });
    enableCameraButton.addEventListener('click', () => startCamera());
    retakeButton.addEventListener('click', retakeCurrentSlot);
    continueButton.addEventListener('click', advanceToNextSlot);
    document.getElementById('photo-again-button').addEventListener('click', startAgain);

    updateUI();
})();
</script>
@endsection
