import { ImgHTMLAttributes } from 'react';
import logo from '@/../../public/logo.png';
import { usePage } from '@inertiajs/react';
import { PageProps } from '@/types';

interface ApplicationLogoProps extends ImgHTMLAttributes<HTMLImageElement> {

  className?: string; // لو عايز تضيف أي كلاس إضافي
}


export default function ApplicationLogo({
  height = 'h-16 md:h-24', // قيمة افتراضية لو ما بعتهاش
  className = '',
  ...props
}: ApplicationLogoProps) {
    const {setting_site} = usePage<PageProps>().props;
    const logobg = setting_site?.logo_image || logo;
    
  return (
    <img
      src={logobg}
      alt="ORCA"
      className={`bg-cover bg-center rounded-lg  ${className}`}
      {...props}
    />
  );
}
