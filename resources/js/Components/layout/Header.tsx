import { Link, usePage } from "@inertiajs/react";
import { cn } from "@/lib/utils";
import {
  LayoutDashboard,
  Users,
  Calendar,
  User,
  Bell,
  Menu,
  X,
  Heart,
} from "lucide-react";
import { useState } from "react";
import { Button } from "@/Components/ui/button";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";

const navItems = [
  { path: "/", label: "Dashboard", icon: LayoutDashboard },
  { path: "/client/list-counselors", label: "Counselors", icon: Users },
  { path: "/client/booking-history", label: "My Bookings", icon: Calendar },
  { path: "/profile", label: "Profile", icon: User },
];

export function Header() {
  const { url } = usePage();
  const pathname = url.split("?")[0];
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  return (
    <header className="sticky top-0 z-50 w-full border-b bg-card/80 backdrop-blur-md">
      <div
        className="
          max-w-screen-xl
          mx-auto
          flex
          h-16
          items-center
          justify-between
          px-4
          md:px-6
        "
      >
       <Link href="/" className="flex items-center gap-2">
          <div className="flex h-12 w-12 items-center justify-center rounded-lg overflow-hidden">
            <img
              src={'/LogoPqNew.png'}
              alt="PersonaQuality Logo"
              className="h-12 w-12 object-contain"
            />
          </div>

          <span className="font-display text-lg font-medium text-foreground">
            PersonaQuality
          </span>
        </Link>



        {/* Desktop Navigation */}
        <nav className="hidden md:flex items-center gap-1">
          {navItems.map((item) => {
            const isActive = pathname === item.path;
            return (
              <Link
                key={item.path}
                href={item.path}
                className={cn(
                  "flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors",
                  isActive
                    ? "bg-primary text-primary-foreground"
                    : "text-muted-foreground hover:text-foreground hover:bg-secondary"
                )}
              >
                <item.icon className="h-4 w-4" />
                {item.label}
              </Link>
            );
          })}
        </nav>

        {/* Right Actions */}
        <div className="flex items-center gap-3">
          {/* <Button variant="ghost" size="icon" className="relative">
            <Bell className="h-5 w-5" />
            <span className="absolute top-1 right-1 h-2 w-2 rounded-full bg-accent" />
          </Button> */}

          <Link href="/profile" className="hidden md:block">
            <Avatar className="h-9 w-9 border-2 border-primary/20">
              <AvatarImage src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face" />
              <AvatarFallback>AJ</AvatarFallback>
            </Avatar>
          </Link>

          {/* Mobile Menu Button */}
          <Button
            variant="ghost"
            size="icon"
            className="md:hidden"
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
          >
            {mobileMenuOpen ? <X className="h-5 w-5" /> : <Menu className="h-5 w-5" />}
          </Button>
        </div>
      </div>

      {/* Mobile Navigation */}
      {mobileMenuOpen && (
        <nav className="md:hidden border-t bg-card p-4 animate-fade-in">
          <div className="flex flex-col gap-2 max-w-screen-xl mx-auto px-4">
            {navItems.map((item) => {
              const isActive = pathname === item.path;
              return (
                <Link
                  key={item.path}
                  href={item.path}
                  onClick={() => setMobileMenuOpen(false)}
                  className={cn(
                    "flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors",
                    isActive
                      ? "bg-primary text-primary-foreground"
                      : "text-muted-foreground hover:text-foreground hover:bg-secondary"
                  )}
                >
                  <item.icon className="h-5 w-5" />
                  {item.label}
                </Link>
              );
            })}
          </div>
        </nav>
      )}
    </header>
  );
}
