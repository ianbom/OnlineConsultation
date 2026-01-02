import { Link } from '@inertiajs/react';
import { Instagram, Linkedin, Mail, Phone } from 'lucide-react';

export function Footer() {
    const currentYear = new Date().getFullYear();

    return (
        <footer className="border-t bg-primary">
            <div className="mx-auto max-w-screen-xl px-4 py-4">
                <div className="flex flex-col items-center justify-between gap-3 md:flex-row">
                    {/* Left */}
                    <p className="text-center text-xs text-white md:text-left">
                        © {currentYear} Persona Quality. Hak cipta dilindungi.
                    </p>

                    {/* Center Links */}
                    <div className="flex gap-4 text-xs text-white">
                        <Link
                            href="/client/dashboard"
                            className="hover:text-white/80"
                        >
                            Dashboard
                        </Link>
                        <Link
                            href="/client/list-counselors"
                            className="hover:text-white/80"
                        >
                            Konselor
                        </Link>
                        <Link
                            href="/client/my-profile"
                            className="hover:text-white/80"
                        >
                            Profile
                        </Link>
                    </div>

                    {/* Right Icons */}
                    <div className="flex gap-3 text-white">
                        <a
                            href="mailto:info@example.com"
                            aria-label="Email"
                            className="hover:text-white/80"
                        >
                            <Mail size={16} />
                        </a>
                        <a
                            href="tel:+62123456789"
                            aria-label="Phone"
                            className="hover:text-white/80"
                        >
                            <Phone size={16} />
                        </a>
                        <a
                            href="https://instagram.com"
                            target="_blank"
                            aria-label="Instagram"
                            className="hover:text-white/80"
                            rel="noreferrer"
                        >
                            <Instagram size={16} />
                        </a>
                        <a
                            href="https://linkedin.com"
                            target="_blank"
                            aria-label="LinkedIn"
                            className="hover:text-white/80"
                            rel="noreferrer"
                        >
                            <Linkedin size={16} />
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    );
}
