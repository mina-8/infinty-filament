import { Head, Link } from '@inertiajs/react'
import React from 'react'
import { useTranslation } from 'react-i18next'
import { IoHomeSharp } from 'react-icons/io5'
interface props{
    ordercode:string;
}
const Success = ({ordercode} : props) => {
    const {t , i18n} = useTranslation()
  return (
        <>
            <Head title={t('order.success.title')} />
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

                <section
                className='my-4 flex justify-center items-center'
                >
                    <div
                    className='bg-green-500 p-4 text-xl font-medium text-white shadow-lg rounded-lg'
                    >
                        {t('order.success.message')}
                    </div>
                </section>
            </section>
        </>
    )
}

export default Success