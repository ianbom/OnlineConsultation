import { MessageCircle } from "lucide-react"

const WAIcon = () => {
  return (
    <div>
<a
  href="https://wa.me/6281234567890?text=Halo%20saya%20ingin%20bertanya"
  target="_blank"
  rel="noopener noreferrer"
  aria-label="WhatsApp"
  className="
    fixed
    bottom-6
    right-6
    z-50
    flex
    items-center
    justify-center
    w-14
    h-14
    rounded-full
    bg-green-500
    text-white
    shadow-lg
    hover:bg-green-600
    hover:scale-105
    transition
    duration-200
  "
>
  <MessageCircle className="w-7 h-7" />
</a>
    </div>
  )
}

export default WAIcon
