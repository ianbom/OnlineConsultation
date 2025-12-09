import { ReactNode } from "react";
import { Header } from "./Header";

interface PageLayoutProps {
  children: ReactNode;
  title?: string;
  description?: string;
}

export function PageLayout({ children, title, description }: PageLayoutProps) {
  return (
    <div className="min-h-screen bg-background">
      <Header />
     <main
        className="
          max-w-screen-xl
          mx-auto
          px-4 md:px-6
          py-6 md:py-8
        "
      >
        {(title || description) && (
          <div className="mb-6 md:mb-8">
            {title && (
              <h1 className="font-display text-2xl md:text-3xl font-semibold text-foreground">
                {title}
              </h1>
            )}
            {description && (
              <p className="mt-1 text-muted-foreground">{description}</p>
            )}
          </div>
        )}
        {children}
      </main>
    </div>
  );
}
