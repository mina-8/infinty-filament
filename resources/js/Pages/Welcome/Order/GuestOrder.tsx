import { getCart } from '@/utils/cartUtils'
import { Head, Link, router } from '@inertiajs/react'
import React, { FormEventHandler, useEffect, useState } from 'react'
import { useTranslation } from 'react-i18next'
import { IoHomeSharp } from 'react-icons/io5'

const GuestOrder = () => {
    const { t, i18n } = useTranslation()
    type CartItem = {
        id: number;
        title: string;
        option_title: string;
        price: number;
        quantity: number;
        total_price: number;
    };

    const [cartitems, setCartitems] = useState<CartItem[]>(JSON.parse(localStorage.getItem('cart') || "[]"));

    // const totalsumprice = cartitems.reduce((sum, item) => sum + Number(item.price), 0);
    const totalsumprice = cartitems.reduce((sum, item) => sum + item.price * item.quantity, 0).toFixed(2);

    const [processing, setProcessing] = useState<boolean>(false);
    const [PaymentMethod, setPaymentMethod] = useState('cash');
    const handelSubmitForm: FormEventHandler = (e) => {
        e.preventDefault();
        setProcessing(true);
        router.post(route('guestorder-store'),
            { cartitems: cartitems.map(item => ({ ...item })), totalsumprice, payment_method: PaymentMethod },
            {
                onFinish: () => setProcessing(false),
                onError: (errors) => console.log(errors)
            })
    }
    return (
        <>
            <Head title={t('order.title')} />
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
                    className='my-8'
                >
                    <table className="w-full text-sm border border-collapse">
                        <thead>
                            <tr>
                                <td className="border p-2 text-center font-semibold">{t('order.table.title')}</td>
                                <td className="border p-2 text-center font-semibold">{t('order.table.unit')}</td>
                                <td className="border p-2 text-center font-semibold">{t('order.table.price')}</td>
                                <td className="border p-2 text-center font-semibold">{t('order.table.quantity')}</td>
                                <td className="border p-2 text-center font-semibold">{t('order.table.total_price')}</td>
                            </tr>
                        </thead>

                        <tbody>
                            {cartitems.map((item, index) =>

                                <tr
                                    key={index}
                                >
                                    <td className="border p-1">
                                        {item.title}
                                    </td>
                                    <td className="border p-1">
                                        {item.option_title}
                                    </td>
                                    <td className="border p-1">
                                        {item.price}
                                    </td>
                                    <td className="border p-1">
                                        {item.quantity}
                                    </td>
                                    <td className="border p-1">
                                        {(item.quantity * Number(item.price)).toFixed(2)}

                                    </td>
                                </tr>

                            )}
                            <tr className='font-semibold'>
                                <td className="border p-1" colSpan={4}>{t('order.table.total')}</td>
                                <td className="border p-1">{totalsumprice}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                {/* form section */}
                <section
                    className='my-8'
                >
                    <form
                        onSubmit={handelSubmitForm}
                        className='space-y-6'
                    >
                        <div>
                            <label
                                className='font-bold text-lg'
                            >
                                {t('order.form.label')}
                            </label>
                            <div
                                className='my-4'
                            >
                                <label >
                                    <input
                                        className='m-2'
                                        required
                                        type="radio"
                                        value='cash'
                                        name='payment_method'
                                        onChange={(e) => setPaymentMethod(e.target.value)}
                                        checked={PaymentMethod === 'cash'}
                                    />
                                    {t('order.form.radio.cash')}
                                </label>
                            </div>

                        </div>
                        <button
                            disabled={processing}
                            className='py-2 px-4 bg-primary-color text-white rounded-lg shadow-lg hover:shadow-sm uppercase'
                        >
                            {t('order.form.submit')}
                        </button>
                    </form>

                </section>

            </section>
        </>
    )
}

export default GuestOrder