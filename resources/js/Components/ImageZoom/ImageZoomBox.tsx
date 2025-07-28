import React, {
  useRef,
  useState,
  useImperativeHandle,
  forwardRef,
} from 'react'
import { useTranslation } from 'react-i18next'

export interface ImageZoomBoxHandle {
  getMainImage: () => string
}

interface Props {
  image: string
  images: string[]
}

const ImageZoomBox = forwardRef<ImageZoomBoxHandle, Props>(
  ({ image, images }, ref) => {
    const { i18n } = useTranslation()
    const imgRef = useRef<HTMLDivElement>(null)
    const zoomRef = useRef<HTMLDivElement>(null)

    const [showZoom, setShowZoom] = useState(false)
    const [activeImage, setActiveImage] = useState(image)

    // 🔹 Expose method to parent via ref
    useImperativeHandle(ref, () => ({
      getMainImage: () => activeImage,
    }))

    const handleMouseMove = (e: React.MouseEvent<HTMLDivElement>) => {
      const img = imgRef.current
      const zoom = zoomRef.current
      if (!img || !zoom) return

      const { left, top, width, height } = img.getBoundingClientRect()
      const x = e.clientX - left
      const y = e.clientY - top

      const xPercent = (x / width) * 100
      const yPercent = (y / height) * 100
      zoom.style.backgroundPosition = `${xPercent}% ${yPercent}%`
    }

    return (
      <>
        <div
          style={{ position: 'relative', display: 'flex', gap: 20 }}
          className="border-2 rounded-lg"
        >
          {/* Image container */}
          <div
            ref={imgRef}
            style={{
              width: '100%',
              height: 500,
              backgroundImage: `url('${activeImage}')`,
              backgroundSize: 'cover',
              backgroundPosition: 'center',
              position: 'relative',
              cursor: 'zoom-in',
            }}
            onMouseEnter={() => setShowZoom(true)}
            onMouseLeave={() => setShowZoom(false)}
            onMouseMove={handleMouseMove}
          />

          {/* Zoom box */}
          {showZoom && (
            <div
              ref={zoomRef}
              className={`absolute top-0 ${
                i18n.language === 'ar' ? '-left-80' : 'left-80'
              } bg-white rounded-lg`}
              style={{
                width: 300,
                height: 300,
                backgroundImage: `url('${activeImage}')`,
                backgroundRepeat: 'no-repeat',
                backgroundSize: '600px 600px',
                border: '1px solid #ccc',
                pointerEvents: 'none',
                zIndex: 10,
              }}
            />
          )}
        </div>

        {/* Thumbnails */}
        <div className="flex items-center gap-2 flex-wrap mt-2">
          {images.map((item, index) => (
            <img
              key={index}
              src={item}
              className={`h-20 border-2 rounded-lg cursor-pointer ${
                item === activeImage ? 'border-blue-500' : ''
              }`}
              onClick={() => setActiveImage(item)}
            />
          ))}
        </div>
      </>
    )
  }
)

export default ImageZoomBox
