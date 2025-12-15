import { Link } from "@inertiajs/react";
import { Facebook, Instagram, Linkedin, Mail, Phone } from "lucide-react";

export function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="border-t bg-muted/30 ">
      <div className="max-w-screen-xl mx-auto px-4 py-4">
        <div className="flex flex-col md:flex-row items-center justify-between gap-3">

          {/* Left */}
          <p className="text-xs text-muted-foreground text-center md:text-left">
            © {currentYear} Persona Quality. Hak cipta dilindungi.
          </p>

          {/* Center Links */}
          <div className="flex gap-4 text-xs">
            <Link href="/client/dashboard" className="hover:text-foreground">
              Dashboard
            </Link>
            <Link href="/client/list-counselors" className="hover:text-foreground">
              Konselor
            </Link>
            <Link href="/client/my-profile" className="hover:text-foreground">
              Profile
            </Link>
          </div>

          {/* Right Icons */}
          <div className="flex gap-3 text-muted-foreground">
            <a href="mailto:info@example.com" aria-label="Email">
              <Mail size={16} />
            </a>
            <a href="tel:+62123456789" aria-label="Phone">
              <Phone size={16} />
            </a>
            <a href="https://instagram.com" target="_blank" aria-label="Instagram">
              <Instagram size={16} />
            </a>
            <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn">
              <Linkedin size={16} />
            </a>
          </div>

        </div>
      </div>
    </footer>
  );
}
