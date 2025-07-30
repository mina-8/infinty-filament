import { getCart, removeFormCart, totalPrice, totalQuantity } from '@/utils/cartUtils'
import { Link } from '@inertiajs/react';
import React, { useEffect, useState } from 'react'
import { useTranslation } from 'react-i18next'
import { IoClose } from 'react-icons/io5';

const CartNav = () => {
    const { t, i18n } = useTranslation();
    const [CartItems, setCarItems] = useState(getCart());
    const handelDecressCart = (productId: number, optionId: number) => {
        removeFormCart(productId, optionId, 1);
    }

    if (totalQuantity() > 0) {
        return (
            <div
                className='flex flex-col gap-4 px-2'
            >
                {CartItems.map((item, index) =>
                    <div
                        key={index}
                        className='border-b-[1px] pb-2'
                    >
                        <div
                            className='flex justify-between gap-2'
                        >
                            <div
                                className='flex gap-2'
                            >
                                <div
                                    className='border-[1px] rounded-lg'
                                >
                                    <img src={item.image} alt={item.title} className='h-14' />
                                </div>
                                <div>
                                    <div>{item.title}</div>
                                    <div
                                        className='flex items-center '
                                    >
                                        <span className='text-sm'>{item.price} KD</span>
                                        <span className='text-sm'>
                                            <IoClose />
                                        </span>
                                        <span className='text-sm'>{item.quantity}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button
                                    type='button'
                                    onClick={() => handelDecressCart(item.productId, item.optionId)}
                                    className=''
                                >
                                    <IoClose />
                                </button>
                            </div>
                        </div>

                    </div>
                )}

                <table
                    className='w-full'
                >
                    <tbody
                        className='border'
                    >
                        <tr>
                            <td className='border p-1'>{t('navbarlist.cartnav.sub_total')}</td>
                            <td className='border p-1'>{totalPrice()} KD</td>
                        </tr>
                        <tr>
                            <td className='border p-1'>{t('navbarlist.cartnav.total')}</td>
                            <td className='border p-1'>{totalPrice()} KD</td>
                        </tr>
                    </tbody>
                </table>

                <div
                className='flex justify-center items-center gap-4'
                >
                    <Link
                    href={route('my-cart' , {lang : i18n.language})}
                    className='bg-primary-color rounded-lg p-2 text-white'
                    >
                        {t('navbarlist.cartnav.view_cart')}
                    </Link>
                    <Link
                    href={route('check-out' , {lang : i18n.language})}
                    className='bg-primary-color rounded-lg p-2 text-white'
                    >
                        {t('navbarlist.cartnav.check_out')}
                    </Link>
                </div>

            </div>
        )
    } else {
        return (
            <div
                className='px-4 w-full flex justify-center items-center'
            >
                {t('navbarlist.cartnav.no_product')}
            </div>
        )
    }
}

export default CartNav