import React from 'react'
import NavLink from '../NavLink'
import { useTranslation } from 'react-i18next';
import { Link, usePage } from '@inertiajs/react';
import { PageProps } from '@/types';

interface ProductInfoNav {
    id: number;
    nav_title: string;
    slug: string;
}
interface Customnav extends PageProps{
 productinfo_nav:ProductInfoNav[]
}

const ServiceNav = () => {
    const { t, i18n } = useTranslation();
    const {productinfo_nav} = usePage<Customnav>().props  ;

    return (
        <div className='flex flex-col whitespace-nowrap px-2'>

            {/* {productinfo_nav.map((item , index)=>(
                <Link
                className='hover:!bg-gray-300 text-primary-color !pt-2 !pb-2 mt-2 group'
                key={index}
                href={route('how-make.show' , {lang:i18n.language , slug:item.slug})}

                >
                    {item.nav_title}
                </Link>
            ))} */}

        </div>
    )
}

export default ServiceNav