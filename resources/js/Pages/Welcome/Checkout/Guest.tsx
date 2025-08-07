import ContentRenderer from '@/Components/ContentRenderer';
import FlexCard from '@/Components/FlexCard';
import GridCard from '@/Components/GridCard';
import Login from '@/Pages/Auth/Login';
import { PageProps } from '@/types';
import { totalQuantity } from '@/utils/cartUtils';
import { GridToggel, setFlexLayout, setGridLayout } from '@/utils/GridUtils';
import { Link, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react'
import { useTranslation } from 'react-i18next';
import { FaList } from 'react-icons/fa';
import { IoHomeSharp } from 'react-icons/io5';
import { RiLayoutGrid2Fill } from 'react-icons/ri';

const Guest = ({ status,
    canResetPassword, }: {
        status?: string;
        canResetPassword: boolean;
    }) => {
    const { t, i18n } = useTranslation();
        const  [cartCount , setCartCoutn ] = useState(0);
        useEffect(()=>{
            const GetCount = async () => {
            const cart = await totalQuantity();
            setCartCoutn(cart);
            }
            GetCount();
        } , [])
        
    return (
        <section
            className='min-h-screen max-w-7xl mx-auto'
        >
            <div
                className='h-48'
            ></div>
            <div className='bg-slate-300 p-2 rounded-lg flex items-center gap-6 px-6'>
                <Link
                    href={route('welcome', { lang: i18n.language })}
                >
                    <IoHomeSharp />
                </Link>


            </div>
            {/* section of header title */}
            <section
                className='lg:grid grid-cols-1 lg:grid-cols-2 gap-4 my-4 hidden'
            >
                <div
                    className='border-2 p-4 w-full gap-4 rounded-lg '
                >
                    <div
                        className='flex flex-col gap-8'
                    >
                        <div
                            className='border-b-2 pb-2 my-1'
                        >{t('guest.new_guest')}</div>
                        <div

                        >{t('guest.accout_content')}</div>
                        <div
                        className='flex  gap-4 items-center'
                        >
                            <Link
                                href={route('register', { lang: i18n.language })}
                                className='bg-primary-color px-4 py-2 rounded-lg text-white font-bold'
                            >
                                {t('guest.add_accout')}
                            </Link>
                            {cartCount > 0 && (
                                <Link
                                href={route('register-guest', { lang: i18n.language })}
                                className='bg-primary-color px-4 py-2 rounded-lg text-white font-bold'
                                >
                                {t('guest.add_accout_guest')}
                            </Link>
                            )}


                        </div>
                    </div>
                </div>


                <div
                    className='border-2 p-4 w-full gap-4 rounded-lg '
                >
                    <div
                        className='border-b-2 pb-2 my-1'
                    >{t('guest.guest')}</div>
                    <Login canResetPassword={canResetPassword} status={status} />
                </div>
            </section>

        </section>
    )
}

export default Guest