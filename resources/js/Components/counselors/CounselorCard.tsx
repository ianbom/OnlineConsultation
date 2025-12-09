import { Star } from "lucide-react";
import { Link } from "react-router-dom";
import { Card, CardContent } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";

interface CounselorCardProps {
  id: string;
  name: string;
  photo: string;
  specializations: string[];
  rating: number;
  reviewCount: number;
  pricePerSession: number;
  isAvailable?: boolean;
}

export function CounselorCard({
  id,
  name,
  photo,
  specializations,
  rating,
  reviewCount,
  pricePerSession,
  isAvailable = true,
}: CounselorCardProps) {
  return (
    <Card className="overflow-hidden group">
      <CardContent className="p-5">
        <div className="flex items-start gap-4">
          <Avatar className="h-16 w-16 rounded-xl border-2 border-primary/10">
            <AvatarImage src={photo} alt={name} className="object-cover" />
            <AvatarFallback className="rounded-xl text-lg">
              {name.split(" ").map((n) => n[0]).join("")}
            </AvatarFallback>
          </Avatar>
          
          <div className="flex-1 min-w-0">
            <div className="flex items-start justify-between gap-2">
              <div>
                <h3 className="font-semibold text-foreground truncate">{name}</h3>
                <div className="flex items-center gap-1 mt-0.5">
                  <Star className="h-4 w-4 fill-warning text-warning" />
                  <span className="text-sm font-medium text-foreground">{rating}</span>
                  <span className="text-sm text-muted-foreground">({reviewCount})</span>
                </div>
              </div>
              <Badge variant={isAvailable ? "success" : "secondary"} className="shrink-0">
                {isAvailable ? "Available" : "Unavailable"}
              </Badge>
            </div>
          </div>
        </div>

        <div className="flex flex-wrap gap-1.5 mt-4">
          {specializations.slice(0, 3).map((spec) => (
            <Badge key={spec} variant="secondary" className="text-xs">
              {spec}
            </Badge>
          ))}
        </div>

        <div className="flex items-center justify-between mt-4 pt-4 border-t">
          <div>
            <span className="text-xl font-semibold text-foreground">
              ${pricePerSession}
            </span>
            <span className="text-sm text-muted-foreground">/session</span>
          </div>
          <Button asChild size="sm">
            <Link to={`/counselors/${id}`}>View Profile</Link>
          </Button>
        </div>
      </CardContent>
    </Card>
  );
}
