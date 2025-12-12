import React, { FormEvent } from 'react';
import { useForm } from '@inertiajs/react';
import { cn } from "@/lib/utils";
import { Button } from "@/Components/ui/button";
import { Card, CardContent } from "@/Components/ui/card";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";

interface RegisterFormProps extends React.ComponentProps<"div"> {}

export function RegisterForm({ className, ...props }: RegisterFormProps) {
  const { data, setData, post, processing, errors, reset } = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });

  const handleSubmit = (e: FormEvent) => {
    e.preventDefault();
    post(route('register'), {
      onFinish: () => reset('password', 'password_confirmation'),
      onError: (errors) => {
        console.error('Register error:', errors);
      },
    });
  };

  return (
    <div className={cn("flex flex-col gap-6", className)} {...props}>
      <Card className="overflow-hidden">
        <CardContent className="grid p-0 md:grid-cols-2">
          <div className="p-6 md:p-8">
            <div className="flex flex-col gap-6">
              <div className="flex flex-col items-center text-center">
                <h1 className="text-2xl font-bold">Buat Akun</h1>
                <p className="text-balance text-muted-foreground">
                 Persona Quality
                </p>
              </div>

              {errors.name && (
                <div className="text-sm text-red-600 bg-red-50 border border-red-200 rounded-md p-3">
                  {errors.name}
                </div>
              )}

              {errors.email && (
                <div className="text-sm text-red-600 bg-red-50 border border-red-200 rounded-md p-3">
                  {errors.email}
                </div>
              )}

              <div className="grid gap-2">
                <Label htmlFor="name">Nama</Label>
                <Input
                  id="name"
                  type="text"
                  placeholder="John Doe"
                  value={data.name}
                  onChange={(e) => setData('name', e.target.value)}
                  required
                  autoComplete="name"
                  autoFocus
                  className={errors.name ? 'border-red-500' : ''}
                />
              </div>

              <div className="grid gap-2">
                <Label htmlFor="email">Email</Label>
                <Input
                  id="email"
                  type="email"
                  placeholder="m@example.com"
                  value={data.email}
                  onChange={(e) => setData('email', e.target.value)}
                  required
                  autoComplete="username"
                  className={errors.email ? 'border-red-500' : ''}
                />
              </div>

              <div className="grid gap-2">
                <Label htmlFor="password">Password</Label>
                <Input
                  id="password"
                  type="password"
                  value={data.password}
                  onChange={(e) => setData('password', e.target.value)}
                  required
                  autoComplete="new-password"
                  className={errors.password ? 'border-red-500' : ''}
                />
                {errors.password && (
                  <p className="text-sm text-red-600">{errors.password}</p>
                )}
              </div>

              <div className="grid gap-2">
                <Label htmlFor="password_confirmation">Konfirmasi Password</Label>
                <Input
                  id="password_confirmation"
                  type="password"
                  value={data.password_confirmation}
                  onChange={(e) => setData('password_confirmation', e.target.value)}
                  required
                  autoComplete="new-password"
                  className={errors.password_confirmation ? 'border-red-500' : ''}
                />
                {errors.password_confirmation && (
                  <p className="text-sm text-red-600">{errors.password_confirmation}</p>
                )}
              </div>

              <Button
                type="button"
                onClick={handleSubmit}
                className="w-full"
                disabled={processing}
              >
                {processing ? 'Mendaftar...' : 'Daftar'}
              </Button>

              <div className="text-center text-sm">
                Sudah punya akun?{" "}
                <a href={route('login')} className="underline underline-offset-4">
                  Masuk
                </a>
              </div>
            </div>
          </div>
          <div className="relative hidden bg-muted md:block">
            <img
              src="/potrait.jpg"
              alt="Image"
              className="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
            />
          </div>
        </CardContent>
      </Card>
      <div className="text-balance text-center text-xs text-muted-foreground [&_a]:underline [&_a]:underline-offset-4 hover:[&_a]:text-primary">
        By clicking continue, you agree to our <a href="#">Terms of Service</a>{" "}
        and <a href="#">Privacy Policy</a>.
      </div>
    </div>
  );
}
