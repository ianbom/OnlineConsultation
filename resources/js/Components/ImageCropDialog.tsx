import { Button } from '@/Components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/Components/ui/dialog';
import { Slider } from '@/Components/ui/slider';
import { useCallback, useState } from 'react';
import Cropper from 'react-easy-crop';

interface ImageCropDialogProps {
    open: boolean;
    imageSrc: string;
    onCropComplete: (croppedImage: string) => void;
    onClose: () => void;
}

interface CroppedAreaPixels {
    x: number;
    y: number;
    width: number;
    height: number;
}

export function ImageCropDialog({
    open,
    imageSrc,
    onCropComplete,
    onClose,
}: ImageCropDialogProps) {
    const [crop, setCrop] = useState({ x: 0, y: 0 });
    const [zoom, setZoom] = useState(1);
    const [croppedAreaPixels, setCroppedAreaPixels] =
        useState<CroppedAreaPixels | null>(null);

    const onCropChange = (location: { x: number; y: number }) => {
        setCrop(location);
    };

    const onZoomChange = (zoom: number) => {
        setZoom(zoom);
    };

    const onCropCompleteHandler = useCallback(
        (_croppedArea: any, croppedAreaPixels: CroppedAreaPixels) => {
            setCroppedAreaPixels(croppedAreaPixels);
        },
        [],
    );

    const createCroppedImage = async () => {
        if (!croppedAreaPixels) return;

        const image = new Image();
        image.src = imageSrc;

        await new Promise((resolve) => {
            image.onload = resolve;
        });

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        if (!ctx) return;

        // Set canvas size to cropped area
        canvas.width = croppedAreaPixels.width;
        canvas.height = croppedAreaPixels.height;

        // Draw the cropped image
        ctx.drawImage(
            image,
            croppedAreaPixels.x,
            croppedAreaPixels.y,
            croppedAreaPixels.width,
            croppedAreaPixels.height,
            0,
            0,
            croppedAreaPixels.width,
            croppedAreaPixels.height,
        );

        // Convert canvas to blob
        canvas.toBlob(
            (blob) => {
                if (!blob) return;

                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = () => {
                    const base64data = reader.result as string;
                    onCropComplete(base64data);
                };
            },
            'image/jpeg',
            0.9,
        );
    };

    const handleApplyCrop = () => {
        createCroppedImage();
        onClose();
    };

    return (
        <Dialog open={open} onOpenChange={onClose}>
            <DialogContent className="max-w-2xl">
                <DialogHeader>
                    <DialogTitle>Crop Foto Profil</DialogTitle>
                </DialogHeader>
                <div className="space-y-4">
                    <div className="relative h-[400px] overflow-hidden rounded-lg bg-gray-100">
                        <Cropper
                            image={imageSrc}
                            crop={crop}
                            zoom={zoom}
                            aspect={1}
                            onCropChange={onCropChange}
                            onZoomChange={onZoomChange}
                            onCropComplete={onCropCompleteHandler}
                        />
                    </div>
                    <div className="space-y-2">
                        <label className="text-sm font-medium">Zoom</label>
                        <Slider
                            min={1}
                            max={3}
                            step={0.1}
                            value={[zoom]}
                            onValueChange={(value) => setZoom(value[0])}
                        />
                    </div>
                    <p className="text-center text-xs text-muted-foreground">
                        Geser dan zoom untuk menyesuaikan area foto (rasio 1:1)
                    </p>
                </div>
                <DialogFooter>
                    <Button variant="outline" onClick={onClose}>
                        Batal
                    </Button>
                    <Button onClick={handleApplyCrop}>Terapkan Crop</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
