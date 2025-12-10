// CounselorInfoCard.tsx

import { Card, CardContent } from "@/Components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import Counselor from "@/Interfaces/Counselor";

interface Props {
  counselor: Counselor;
}

export default function CounselorInfoCard({ counselor }: Props) {
  const profilePicUrl = counselor.user.profile_pic
    ? `/storage/${counselor.user.profile_pic}`
    : null;

  return (
    <Card className="mb-6">
      <CardContent className="p-4">
        <div className="flex items-center gap-4">

          {/* Avatar */}
          <Avatar className="h-14 w-14 rounded-lg">
            <AvatarImage
              src={profilePicUrl || undefined}
              alt={counselor.user.name}
            />
            <AvatarFallback className="rounded-lg">
              {counselor.user.name
                .split(" ")
                .map((n) => n[0])
                .join("")}
            </AvatarFallback>
          </Avatar>

          {/* Info Konselor */}
          <div>
            <h2 className="font-semibold text-foreground">
              {counselor.user.name}
            </h2>

            <p className="text-sm text-muted-foreground">
              Rp {counselor.price_per_session.toLocaleString("id-ID")} per sesi
            </p>

            <p className="text-xs text-muted-foreground mt-1">
              Pilih 1–2 jam konseling yang berdampingan
            </p>
          </div>

        </div>
      </CardContent>
    </Card>
  );
}
