import { getWichList, WichList } from '@/utils/cartUtils'
import { Head, Link } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { useTranslation } from 'react-i18next'
import { IoHomeSharp } from 'react-icons/io5'

const Index = () => {
    const {t , i18n} = useTranslation();
    const [wishlist , setWishlist] = useState<WichList[]>([]);
    useEffect(()=>{
        setWishlist(getWichList())
    } , [])
    return (
        <>
            <Head title='wish list' />
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
                className='grid grid-cols-2 lg:grid-cols-3 gap-4 my-4'
                >
                    {wishlist.map((item , index)=>
                        <Link
                        href={route('product-show' , {lang:i18n.language , state:item.state , product:item.slug})}
                        key={item.productId}
                        className='p-4 border-2 rounded-lg shadow-lg hover:shadow-sm flex flex-col items-center gap-4'
                        >

                            <img src={item.image} alt="product" />

                            <p>{item.title}</p>

                        </Link>
                    )}
                </section>

            </section>
        </>
    )
}

export default Index