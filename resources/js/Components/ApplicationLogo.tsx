import { ImgHTMLAttributes } from 'react';
import logo from '@/../../public/logo.svg';

interface ApplicationLogoProps extends ImgHTMLAttributes<HTMLImageElement> {
  height?: string; // نسمح بتمرير كلاس tailwind للارتفاع
  className?: string; // لو عايز تضيف أي كلاس إضافي
}

export default function ApplicationLogo({
  height = 'h-16 md:h-24', // قيمة افتراضية لو ما بعتهاش
  className = '',
  ...props
}: ApplicationLogoProps) {
  return (
    <img
      src={logo}
      alt="ORCA"
      className={`bg-cover bg-center rounded-lg ${height} ${className}`}
      {...props}
    />
  );
}
