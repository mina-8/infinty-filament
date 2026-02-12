
import { Head, router, usePage } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { useTranslation } from 'react-i18next'
import banner from '@/../../public/aboutus/image (1).jfif'
import { countries } from '@/Components/AllCountry/countries'
import { PageProps } from '@/types'
import { FaExclamationCircle, FaFax, FaHome, FaPhoneAlt } from 'react-icons/fa'
import { IoIosArrowDropleft, IoIosArrowDropright } from 'react-icons/io'
import { Drawer } from 'antd'

interface FlashMessages {
    success?: string | null;
    error?: string | null;
}

interface Customflash extends PageProps {
    flash?: FlashMessages;
}

const Index = () => {
    const { t, i18n } = useTranslation();
    const { props } = usePage<Customflash>();
    const [showSuccess, setShowSuccess] = useState<boolean>(!!props?.flash?.success);
    const SuccessMessage = props?.flash?.success;
    const { errors } = usePage().props;
    const [Loading, setLoading] = useState(false);

    const [open, setOpen] = useState(false);

    const showDrawer = () => {
        setOpen(true);
    };

    const onClose = () => {
        setOpen(false);
    };

    useEffect(() => {
        if (SuccessMessage) {
            setShowSuccess(true);
            const timer = setTimeout(() => {
                setShowSuccess(false);
            }, 10000); // 10 seconds

            return () => clearTimeout(timer); // Cleanup on unmount
        }
    }, [SuccessMessage]);
    const [formData, setFormData] = useState({
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        company_name: '',
        country: '',
        message: '',
    });


    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setFormData({ ...formData, [name]: value });
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        router.post(route('contact-us', { lang: i18n.language }), formData, {
            onSuccess: () => {
                setFormData({
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    company_name: '',
                    country: '',
                    message: '',
                })
            },
            onBefore: () => setLoading(true),
            onFinish: () => setLoading(false)
        })
    };
    return (
        <>
            {showSuccess && (
                <div className="fixed top-4 left-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg transition duration-500">
                    {SuccessMessage}
                </div>
            )}

            <Head title={t('navbar-links.contact-us')} />
            <div
                className="relativ flex flex-col"
            >

                {/* top banner */}
                <div
                    className="w-full h-[300px] flex relative overflow-hidden"
                >
                    <div
                        className="w-full h-full bg-cover  absolute"
                        // style={{
                        //     backgroundImage: `url('${contactus.banner != null ? contactus.banner :  banner}')`,
                        //     backgroundPosition: 'center center',
                        //     backgroundRepeat: 'no-repeat'
                        // }}
                    />
                    <div className='absolute w-full h-full bg-black top-0 right-0 opacity-50'></div>

                </div>
                {/* create form contact us */}
                <div
                    className='w-full max-w-7xl mx-auto my-12 flex flex-col md:flex-row justify-between'
                >
                    <div
                        className='flex flex-col  gap-6 bg-white py-6 -top-40 relative px-4 w-2/3'
                    >
                        <h2
                            className={`px-4 sm:px-6 lg:px-8 text-6xl text-black font-bold`}
                        >
                            {t('navbar-links.contact-us')}
                        </h2>
                        <p
                            className='text-primary-color px-4 sm:px-6 lg:px-8'
                        >
                            {t('contact.required')}
                        </p>
                        <form onSubmit={handleSubmit} className='flex flex-col justify-center items-center gap-12'>
                            <div
                                className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4  w-full'
                            >
                                <input type='text' name='first_name' placeholder={t('contact.fname')} value={formData.first_name} onChange={handleChange}
                                    className='w-full border  px-4 py-4 mb-4'
                                    required />
                                {errors.first_name && <div className="text-red-500 text-sm">{errors.first_name}</div>}
                                <input type='text' name='last_name' placeholder={t('contact.lname')} value={formData.last_name} onChange={handleChange}
                                    className='w-full border  px-4 py-4 mb-4 '
                                    required />
                                {errors.last_name && <div className="text-red-500 text-sm">{errors.last_name}</div>}
                            </div>
                            <div
                                className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4  w-full'
                            >
                                <input type='email' name='email' placeholder={t('contact.email')} value={formData.email} onChange={handleChange}
                                    className='w-full border  px-4 py-4 mb-4'
                                    required />
                                {errors.email && <div className="text-red-500 text-sm">{errors.email}</div>}
                                <input type='tel' name='phone' placeholder={t('contact.phone')} value={formData.phone} onChange={handleChange}
                                    className='w-full border  px-4 py-4 mb-4 '
                                    required />
                                {errors.phone && <div className="text-red-500 text-sm">{errors.phone}</div>}
                            </div>

                            <select name='country' value={formData.country} onChange={handleChange} style={{ backgroundImage: 'none' }}
                                className='w-full border  px-4 py-4 '
                                required>
                                <option value="">{t('contact.select_country')}</option>
                                {countries.map((country) => (
                                    <option key={country} value={country}>
                                        {country}
                                    </option>
                                ))}
                            </select>
                            {errors.country && <div className="text-red-500 text-sm">{errors.country}</div>}

                            <textarea name='message' placeholder={t('contact.message')} value={formData.message} onChange={handleChange} className='w-full border  px-4 py-2' rows={4} required />
                            {errors.message && <div className="text-red-500 text-sm">{errors.message}</div>}

                            <button type='submit'
                                disabled={Loading}
                                className={`p-4 ${Loading ? 'bg-gray-200' : 'bg-primary-color'}  text-white font-semibold text-lg shadow-md hover:shadow-none cursor-pointer rounded-lg self-start`}
                            >{t('contact.submit')}</button>
                        </form>
                    </div>


                </div>


            </div>


        </>
    )
}

export default Index