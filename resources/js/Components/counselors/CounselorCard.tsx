import { Link } from "@inertiajs/react";
import { Card, CardContent } from "@/Components/ui/card";
import { Badge } from "@/Components/ui/badge";
import { Button } from "@/Components/ui/button";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";

interface CounselorCardProps {
  id: string;
  name: string;
  photo: string;
  specializations: string[];
  pricePerSession: number;
  isAvailable: boolean;
}

export function CounselorCard({
  id,
  name,
  photo,
  specializations,
  pricePerSession,
  isAvailable,
}: CounselorCardProps) {
  const baseUrl = import.meta.env.VITE_APP_URL;
  const photoUrl = photo
    ? `${baseUrl}/storage/${photo}`
    : "/default-avatar.png";

  return (
    <Card className="border rounded-xl hover:shadow-md transition-all duration-200">
      <CardContent className="p-4">
        {/* Top Section */}
        <div className="flex items-center gap-3">
          <Avatar className="h-12 w-12 rounded-lg border">
            <AvatarImage src={photoUrl} alt={name} className="object-cover" />
            <AvatarFallback className="rounded-lg text-sm font-medium bg-primary/10 text-primary">
              {name.split(",").map((n) => n.trim()[0]).join("")}
            </AvatarFallback>
          </Avatar>

          <div className="flex-1 min-w-0">
            <h3 className="font-semibold text-sm text-foreground truncate">
              {name}
            </h3>

          </div>

          <Badge
            variant={isAvailable ? "success" : "destructive"}
            className="text-[10px] py-0.5 px-2"
          >
            {isAvailable ? "Active" : "Inactive"}
          </Badge>
        </div>

        {/* Specializations */}
        <div className="flex flex-wrap gap-1 mt-3">
          {specializations.slice(0, 2).map((spec) => (
            <Badge
              key={spec}
              variant="secondary"
              className="text-[10px] px-2 py-0.5 whitespace-nowrap"
            >
              {spec.replace(/,/g, "")}
            </Badge>
          ))}

          {specializations.length > 2 && (
            <Badge variant="outline" className="text-[10px] px-2 py-0.5">
              +{specializations.length - 2}
            </Badge>
          )}
        </div>


        {/* Bottom Section */}
        <div className="flex items-center justify-between mt-4">
          <div>
            <span className="text-sm text-muted-foreground block">Fee</span>
            <span className="text-lg font-semibold text-primary">
              Rp{pricePerSession.toLocaleString("id-ID")}
            </span>
          </div>

          {isAvailable ? (
            <Button
              asChild
              size="sm"
              className="text-xs px-3 py-1 h-7 bg-primary hover:bg-primary/80"
            >
              <Link href={route("client.counselor.show", id)}>Pesan Konsultasi</Link>
            </Button>
          ) : (
            <Button
              size="sm"
              disabled
              className="text-xs px-3 py-1 h-7"
            >
              Tidak Tersedia
            </Button>
          )}

        </div>
      </CardContent>
    </Card>
  );
}
