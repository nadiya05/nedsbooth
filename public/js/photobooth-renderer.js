/**
 * Fixed photobooth layouts for a 600 px-wide output canvas.
 * HD output dimensions scale slot coordinates independently on each axis.
 */
export const PHOTOBOOTH_LAYOUTS = Object.freeze({
    3: Object.freeze({
        width: 600,
        height: 1800,
        slots: Object.freeze([
            Object.freeze({ x: 50, y: 100, width: 500, height: 400 }),
            Object.freeze({ x: 50, y: 550, width: 500, height: 400 }),
            Object.freeze({ x: 50, y: 1000, width: 500, height: 400 }),
        ]),
    }),
    2: Object.freeze({
        width: 600,
        height: 1200,
        slots: Object.freeze([
            Object.freeze({ x: 50, y: 80, width: 500, height: 450 }),
            Object.freeze({ x: 50, y: 580, width: 500, height: 450 }),
        ]),
    }),
    1: Object.freeze({
        width: 600,
        height: 800,
        slots: Object.freeze([
            Object.freeze({ x: 50, y: 60, width: 500, height: 600 }),
        ]),
    }),
});

/** Return scaled slot coordinates for a chosen photo count and output size. */
export function getPhotoBoothLayout(photoCount, outputWidth, outputHeight) {
    const layout = PHOTOBOOTH_LAYOUTS[photoCount];
    if (!layout) throw new RangeError('photoCount must be 1, 2, or 3.');

    const width = outputWidth ?? layout.width;
    const height = outputHeight ?? layout.height;
    if (!Number.isFinite(width) || !Number.isFinite(height) || width <= 0 || height <= 0) {
        throw new RangeError('Canvas width and height must be positive numbers.');
    }

    const scaleX = width / layout.width;
    const scaleY = height / layout.height;
    return {
        width,
        height,
        slots: layout.slots.map(slot => ({
            x: slot.x * scaleX,
            y: slot.y * scaleY,
            width: slot.width * scaleX,
            height: slot.height * scaleY,
        })),
    };
}

/** Draw an image using center-crop / object-fit: cover without distortion. */
export function drawImageCover(context, image, x, y, width, height) {
    const sourceWidth = image.naturalWidth || image.videoWidth || image.width;
    const sourceHeight = image.naturalHeight || image.videoHeight || image.height;
    if (!sourceWidth || !sourceHeight) throw new TypeError('A photo must be fully loaded before rendering.');

    const sourceAspect = sourceWidth / sourceHeight;
    const targetAspect = width / height;
    let sourceX = 0;
    let sourceY = 0;
    let cropWidth = sourceWidth;
    let cropHeight = sourceHeight;

    if (sourceAspect > targetAspect) {
        cropWidth = sourceHeight * targetAspect;
        sourceX = (sourceWidth - cropWidth) / 2;
    } else {
        cropHeight = sourceWidth / targetAspect;
        sourceY = (sourceHeight - cropHeight) / 2;
    }

    context.drawImage(image, sourceX, sourceY, cropWidth, cropHeight, x, y, width, height);
}

/**
 * Render photos and a transparent frame overlay into a canvas.
 * @param {HTMLCanvasElement} canvasElement Output canvas.
 * @param {Array<CanvasImageSource>} arrayOfPhotos Captured photos in slot order.
 * @param {HTMLImageElement|CanvasImageSource} frameImageElement Transparent frame overlay.
 * @param {1|2|3} photoCount Number of photos/layout to render.
 * @param {{width?: number, height?: number}} [outputSize] Optional HD canvas dimensions.
 * @returns {HTMLCanvasElement} The rendered canvas.
 */
export function renderPhotoBooth(canvasElement, arrayOfPhotos, frameImageElement, photoCount, outputSize = {}) {
    if (!(canvasElement instanceof HTMLCanvasElement)) {
        throw new TypeError('canvasElement must be an HTMLCanvasElement.');
    }
    if (!Array.isArray(arrayOfPhotos) || arrayOfPhotos.length < photoCount) {
        throw new RangeError(`Provide at least ${photoCount} captured photo(s).`);
    }

    const layout = getPhotoBoothLayout(photoCount, outputSize.width, outputSize.height);
    const frameWidth = frameImageElement.naturalWidth || frameImageElement.videoWidth || frameImageElement.width;
    const frameHeight = frameImageElement.naturalHeight || frameImageElement.videoHeight || frameImageElement.height;
    if (!frameWidth || !frameHeight) throw new TypeError('The frame overlay must be fully loaded before rendering.');

    canvasElement.width = layout.width;
    canvasElement.height = layout.height;
    const context = canvasElement.getContext('2d');
    if (!context) throw new Error('A 2D canvas context is not available.');

    context.clearRect(0, 0, layout.width, layout.height);
    layout.slots.forEach((slot, index) => {
        drawImageCover(context, arrayOfPhotos[index], slot.x, slot.y, slot.width, slot.height);
    });

    // Layer 2: composite the transparent frame over the completed photo slots.
    context.drawImage(frameImageElement, 0, 0, layout.width, layout.height);
    return canvasElement;
}
