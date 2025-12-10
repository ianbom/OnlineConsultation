import { useState, FormEvent, useRef } from "react";
import { router } from "@inertiajs/react";
import { PageLayout } from "@/Components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/components/ui/label";
import { Switch } from "@/Components/ui/switch";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import { Separator } from "@/Components/ui/separator";
import { Camera, Mail, Phone, Lock, Bell, User, Calendar } from "lucide-react";
import { useToast } from "@/hooks/use-toast";
import { format } from "date-fns";

interface User {
  id: number;
  name: string;
  email: string;
  role: string;
  phone: string | null;
  profile_pic: string | null;
  email_verified_at: string | null;
  created_at: string;
  updated_at: string;
}

interface Props {
  user: User;
}

export default function ClientProfile({ user }: Props) {
  const { toast } = useToast();
  const fileInputRef = useRef<HTMLInputElement>(null);
  const [processing, setProcessing] = useState(false);
  const [profilePicPreview, setProfilePicPreview] = useState<string | null>(
    user.profile_pic ? `/storage/${user.profile_pic}` : null
  );
  const [profilePicFile, setProfilePicFile] = useState<File | null>(null);

  const [formData, setFormData] = useState({
    name: user.name,
    email: user.email,
    phone: user.phone || "",
    password: "",
    confirmPassword: "",
  });

//   const [preferences, setPreferences] = useState({
//     notifications: true,
//     emailReminders: true,
//     smsReminders: false,
//   });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData((prev) => ({
      ...prev,
      [e.target.name]: e.target.value,
    }));
  };

  const handleProfilePicClick = () => {
    fileInputRef.current?.click();
  };

  const handleProfilePicChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      // Validasi file
      if (!file.type.startsWith('image/')) {
        toast({
          title: "Error",
          description: "File harus berupa gambar.",
          variant: "destructive",
        });
        return;
      }

      if (file.size > 2 * 1024 * 1024) { // 2MB
        toast({
          title: "Error",
          description: "Ukuran file maksimal 2MB.",
          variant: "destructive",
        });
        return;
      }

      setProfilePicFile(file);

      // Preview image
      const reader = new FileReader();
      reader.onloadend = () => {
        setProfilePicPreview(reader.result as string);
      };
      reader.readAsDataURL(file);
    }
  };

  const handleSave = (e: FormEvent) => {
    e.preventDefault();

    if (formData.password && formData.password !== formData.confirmPassword) {
      toast({
        title: "Error",
        description: "Password tidak cocok.",
        variant: "destructive",
      });
      return;
    }

    setProcessing(true);

    // Gunakan FormData untuk mengirim file
    const dataToSubmit = new FormData();

    // Kirim nilai baru atau nilai lama jika tidak diubah
    dataToSubmit.append('name', formData.name || user.name);
    dataToSubmit.append('email', formData.email || user.email);
    dataToSubmit.append('phone', formData.phone || user.phone || '');

    // Hanya kirim profile_pic jika ada file baru yang dipilih
    if (profilePicFile) {
      dataToSubmit.append('profile_pic', profilePicFile);
    }

    // Hanya kirim password jika diisi
    if (formData.password && formData.password.trim() !== '') {
      dataToSubmit.append('password', formData.password);
      dataToSubmit.append('password_confirmation', formData.confirmPassword);
    }

    // Tambahkan _method untuk spoofing PUT request
    dataToSubmit.append('_method', 'POST');

    router.post(route('client.profile.update'), dataToSubmit, {
      forceFormData: true,
      onSuccess: () => {
        toast({
          title: "Berhasil",
          description: "Profil Anda berhasil diperbarui.",
        });
        setFormData(prev => ({
          ...prev,
          password: "",
          confirmPassword: "",
        }));
        setProfilePicFile(null);
      },
      onError: (errors) => {
        const errorMessage = Object.values(errors).flat().join(', ') ||
          "Gagal memperbarui profil. Silakan periksa input Anda.";
        toast({
          title: "Error",
          description: errorMessage,
          variant: "destructive",
        });
      },
      onFinish: () => {
        setProcessing(false);
      },
    });
  };

  const getInitials = (name: string) => {
    return name
      .split(" ")
      .map((n) => n[0])
      .join("")
      .toUpperCase();
  };

  const getMemberDuration = () => {
    const created = new Date(user.created_at);
    const now = new Date();
    const months = Math.floor((now.getTime() - created.getTime()) / (1000 * 60 * 60 * 24 * 30));
    return months > 0 ? `${months} bulan` : 'Kurang dari sebulan';
  };

  return (
    <PageLayout title="Profil Saya" description="Kelola pengaturan akun dan preferensi Anda">
      <div className="max-w-4xl mx-auto">
        <div className="grid gap-6 md:grid-cols-3">
          {/* Profile Preview */}
          <div className="space-y-6">
            <Card>
              <CardContent className="p-6 text-center">
                <div className="relative inline-block">
                  <Avatar className="h-24 w-24 mx-auto border-4 border-primary/10">
                    <AvatarImage src={profilePicPreview || undefined} alt={user.name} />
                    <AvatarFallback className="text-2xl">
                      {getInitials(user.name)}
                    </AvatarFallback>
                  </Avatar>
                  <button
                    type="button"
                    onClick={handleProfilePicClick}
                    className="absolute bottom-0 right-0 h-8 w-8 rounded-full bg-primary text-primary-foreground flex items-center justify-center shadow-md hover:bg-primary/90 transition-colors"
                  >
                    <Camera className="h-4 w-4" />
                  </button>
                  <input
                    ref={fileInputRef}
                    type="file"
                    accept="image/*"
                    onChange={handleProfilePicChange}
                    className="hidden"
                  />
                </div>
                <h2 className="font-display text-xl font-semibold text-foreground mt-4">
                  {user.name}
                </h2>
                <p className="text-sm text-muted-foreground">{user.email}</p>
                <div className="flex items-center justify-center gap-1 mt-2 text-sm text-muted-foreground">
                  <Calendar className="h-4 w-4" />
                  <span>Sejak {format(new Date(user.created_at), "MMMM yyyy")}</span>
                </div>
              </CardContent>
            </Card>

            {/* Quick Stats */}
            <Card>
              <CardHeader className="pb-3">
                <CardTitle className="text-base">Statistik Cepat</CardTitle>
              </CardHeader>
              <CardContent className="space-y-3">
                <div className="flex justify-between text-sm">
                  <span className="text-muted-foreground">Status Email</span>
                  <span className="font-medium text-foreground">
                    {user.email_verified_at ? "Terverifikasi" : "Belum Terverifikasi"}
                  </span>
                </div>
                <div className="flex justify-between text-sm">
                  <span className="text-muted-foreground">Aktif Sejak</span>
                  <span className="font-medium text-foreground">{getMemberDuration()}</span>
                </div>
              </CardContent>
            </Card>
          </div>

          {/* Settings Forms */}
          <div className="md:col-span-2 space-y-6">
            {/* Personal Information */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <User className="h-5 w-5 text-primary" />
                  Informasi Pribadi
                </CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="grid gap-4 sm:grid-cols-2">
                  <div className="space-y-2">
                    <Label htmlFor="name">Nama Lengkap</Label>
                    <Input
                      id="name"
                      name="name"
                      value={formData.name}
                      onChange={handleChange}
                      placeholder="Masukkan nama Anda"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="phone">Nomor Telepon</Label>
                    <div className="relative">
                      <Phone className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                      <Input
                        id="phone"
                        name="phone"
                        value={formData.phone}
                        onChange={handleChange}
                        placeholder="Masukkan nomor telepon"
                        className="pl-10"
                      />
                    </div>
                  </div>
                </div>
                <div className="space-y-2">
                  <Label htmlFor="email">Alamat Email</Label>
                  <div className="relative">
                    <Mail className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                    <Input
                      id="email"
                      name="email"
                      type="email"
                      value={formData.email}
                      onChange={handleChange}
                      placeholder="Masukkan alamat email"
                      className="pl-10"
                    />
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Password */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <Lock className="h-5 w-5 text-primary" />
                  Ubah Password
                </CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="grid gap-4 sm:grid-cols-2">
                  <div className="space-y-2">
                    <Label htmlFor="password">Password Baru</Label>
                    <Input
                      id="password"
                      name="password"
                      type="password"
                      value={formData.password}
                      onChange={handleChange}
                      placeholder="Masukkan password baru"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="confirmPassword">Konfirmasi Password</Label>
                    <Input
                      id="confirmPassword"
                      name="confirmPassword"
                      type="password"
                      value={formData.confirmPassword}
                      onChange={handleChange}
                      placeholder="Konfirmasi password baru"
                    />
                  </div>
                </div>
                <p className="text-xs text-muted-foreground">
                  Kosongkan jika tidak ingin mengubah password
                </p>
              </CardContent>
            </Card>

            {/* Notifications */}
            {/* <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <Bell className="h-5 w-5 text-primary" />
                  Preferensi Notifikasi
                </CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="flex items-center justify-between">
                  <div>
                    <p className="font-medium text-foreground">Notifikasi Push</p>
                    <p className="text-sm text-muted-foreground">
                      Terima notifikasi tentang appointment dan update
                    </p>
                  </div>
                  <Switch
                    checked={preferences.notifications}
                    onCheckedChange={(checked) =>
                      setPreferences(prev => ({ ...prev, notifications: checked }))
                    }
                  />
                </div>
                <Separator />
                <div className="flex items-center justify-between">
                  <div>
                    <p className="font-medium text-foreground">Pengingat Email</p>
                    <p className="text-sm text-muted-foreground">
                      Dapatkan pengingat email sebelum sesi Anda
                    </p>
                  </div>
                  <Switch
                    checked={preferences.emailReminders}
                    onCheckedChange={(checked) =>
                      setPreferences(prev => ({ ...prev, emailReminders: checked }))
                    }
                  />
                </div>
                <Separator />
                <div className="flex items-center justify-between">
                  <div>
                    <p className="font-medium text-foreground">Pengingat SMS</p>
                    <p className="text-sm text-muted-foreground">
                      Terima pengingat melalui pesan teks
                    </p>
                  </div>
                  <Switch
                    checked={preferences.smsReminders}
                    onCheckedChange={(checked) =>
                      setPreferences(prev => ({ ...prev, smsReminders: checked }))
                    }
                  />
                </div>
              </CardContent>
            </Card> */}

            {/* Save Button */}
            <div className="flex justify-end">
              <Button size="lg" onClick={handleSave} disabled={processing}>
                {processing ? "Menyimpan..." : "Simpan Perubahan"}
              </Button>
            </div>
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
