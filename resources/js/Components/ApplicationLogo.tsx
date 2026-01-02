import { ImgHTMLAttributes } from 'react';

export default function ApplicationLogo(
    props: ImgHTMLAttributes<HTMLImageElement>,
) {
    return <img src="/LogoPqNew.png" alt="Application Logo" {...props} />;
}
