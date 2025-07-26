import React, { useState } from 'react'
import { useTranslation } from 'react-i18next';
import mobawon from '@/../../public/logo-mobdwon.png'
import { Link, usePage } from '@inertiajs/react';
import ApplicationLogo from '@/Components/ApplicationLogo';

import { PageProps } from '@/types';

import DynamicIcon from '@/Components/DynamicIcon/DynamicIcon';
import { FaFacebook, FaInstagram, FaLinkedin, FaPhoneAlt, FaTiktok } from 'react-icons/fa';
import { FaXTwitter } from 'react-icons/fa6';
import { AiFillHome } from 'react-icons/ai';
import { Button, Modal } from 'antd';

interface SocialLink {
    id: number;
    link: string;
    icon_path: string;
}
interface OfficeRegional {
    id: number;
    state: string;
    address: string;
    phone: string;
    phone_free: string;
    fax: string;
    email: string
}
interface CustomBrand extends PageProps {


    socialicons: SocialLink[];
    office_reginal: OfficeRegional[]
}


const Footer = () => {
    const { t, i18n } = useTranslation();
    const currentYear = new Date().getFullYear();
    const { socialicons } = usePage<CustomBrand>().props;
    const { productinfo_nav } = usePage<CustomBrand>().props;
    const { office_reginal } = usePage<CustomBrand>().props;
    const { site_setting }: string | any = usePage().props;

    const Spotlight = [

        {

            href: 'work-us',
            title: t('footer.work-us')
        },

        {
            href: 'contact-us',
            title: t('footer.delivery')
        },
        {
            href: 'contact-us',
            title: t('home.contact_us')
        },

    ];

    const [isModalOpen, setIsModalOpen] = useState(false);

    const showModal = () => {
        setIsModalOpen(true);
    };

    const handleOk = () => {
        setIsModalOpen(false);
    };

    const handleCancel = () => {
        setIsModalOpen(false);
    };


    return (
        <footer className="bg-wheat  w-full">
            <div className="mx-auto max-w-7xl px-4 py-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

                {/* Logo & Description & Social */}
                <div className={`flex flex-col items-center md:items-start gap-4 border-b pb-6 lg:pb-0 lg:border-b-0
                    border-gray-300
                    ${i18n.language === 'ar' ? 'lg:border-l' : 'lg:border-r'}`}
                >
                    <div className="flex flex-col md:flex-row justify-between gap-8 ">
                        {/* المكتب الرئيسي */}
                        <div className="flex flex-col gap-4 md:w-1/2">
                            <h2 className="text-xl font-bold text-black">{t('footer.contact_us')}</h2>

                            {office_reginal.length > 0 && (
                                <>
                                    <h3 className="text-lg font-semibold ">
                                        {office_reginal[0].state}
                                    </h3>

                                    <ul className="space-y-4">
                                        <li className="flex items-start gap-3">
                                            <AiFillHome className="text-primary-color text-3xl flex-shrink-0" />
                                            <p className="text-gray-700 leading-relaxed">
                                                {office_reginal[0].address}
                                            </p>
                                        </li>

                                        <li className="flex items-center gap-3">
                                            <FaPhoneAlt className="text-primary-color text-3xl flex-shrink-0" />
                                            <p className="text-gray-700">{office_reginal[0].phone}</p>
                                        </li>
                                    </ul>
                                </>
                            )}
                        </div>

                        {/* المكاتب الأخرى */}
                        <div className="flex flex-col gap-4 md:w-1/2">
                            <h2 className="text-xl font-bold text-black">{t('footer.other_office')}</h2>

                            <ul className="space-y-3">
                                {office_reginal.length > 1 &&
                                    office_reginal
                                        .slice(1) // استبعاد أول مكتب
                                        .map((office, idx) => (
                                            <li key={idx} className="pb-3">
                                                <h4
                                                    onClick={showModal}
                                                    className="font-semibold underline cursor-pointer">{office.state}</h4>

                                                <Modal
                                                    // title="Basic Modal"
                                                    // closable={{ 'aria-label': 'Custom Close Button' }}
                                                    open={isModalOpen}
                                                    onOk={handleOk}
                                                    // closable={false}
                                                    // closeIcon={false}
                                                    // onCancel={handleCancel}
                                                    footer={[
                                                        <Button key="ok" type="primary" onClick={handleOk}>
                                                            OK
                                                        </Button>,
                                                    ]}

                                                >
                                                    <div
                                                    className='flex flex-col justify-center items-center gap-4'
                                                    >
                                                    <p>
                                                        {office.state}
                                                    </p>
                                                    <p
                                                    className='text-center'
                                                    >
                                                        {office.address}
                                                    </p>
                                                    <p>
                                                        {office.phone}
                                                    </p>
                                                    <p>
                                                        {office.fax}
                                                    </p>
                                                    {office.phone_free && (
                                                        <p>{office.phone_free}</p>
                                                    )}
                                                    <p>
                                                        {office.email}
                                                    </p>
                                                    </div>

                                                </Modal>
                                            </li>
                                        ))}
                            </ul>
                        </div>
                    </div>


                    <div className="flex gap-4 flex-wrap justify-center md:justify-start">

                        {socialicons.length > 0 ? socialicons.map((social) => (
                            <a
                                key={social.id}
                                href={social.link}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="rounded-full bg-primary-color text-white p-2"
                            >
                                <DynamicIcon iconPath={social.icon_path} />
                            </a>
                        )) : (
                            <>
                                <a
                                    href='https://www.linkedin.com/company/bscosa/'
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="rounded-full bg-primary-color text-white p-2"
                                >
                                    <FaLinkedin />
                                </a>
                                <a
                                    href='https://x.com/BscoCom'
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="rounded-full bg-primary-color text-white p-2"
                                >
                                    <FaXTwitter />
                                </a>
                                <a
                                    href='https://www.facebook.com/profile.php?id=61558624079654'
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="rounded-full bg-primary-color text-white p-2"
                                >
                                    <FaFacebook />
                                </a>
                                <a
                                    href='https://www.instagram.com/bsco_sa_com/'
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="rounded-full bg-primary-color text-white p-2"
                                >
                                    <FaInstagram />
                                </a>
                                <a
                                    href='https://www.tiktok.com/@bsco.sa?lang=en'
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="rounded-full bg-primary-color text-white p-2"
                                >
                                    <FaTiktok />
                                </a>
                            </>
                        )}


                    </div>


                </div>



                {/* Links Grid */}
                <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    {/* Section: About */}
                    <div className="flex flex-col gap-4">
                        <Link
                            href={route('about-us')}
                            className="text-xl text-black font-bold">{t('footer.about_us')}</Link>
                        <ul className="space-y-1">
                            <li><Link href={route('our-story', { lang: i18n.language })} className="hover:text-primary-color">{t('footer.ourstory')}</Link></li>
                            <li><Link href={route('our-promise', { lang: i18n.language })} className="hover:text-primary-color">{t('footer.ourpromise')}</Link></li>
                            <li><Link href={route('news', { lang: i18n.language })} className="hover:text-primary-color">{t('footer.ournews')}</Link></li>
                            <li><Link href={`${route('about-us', { lang: i18n.language })}#certif`} className="hover:text-primary-color">{t('footer.certif')}</Link></li>
                        </ul>
                    </div>


                    {/* Section: Products */}
                    <div className="flex flex-col gap-4">
                        <Link
                            href={route('about-us')}
                            className="text-xl text-black font-bold">{t('footer.services')}</Link>
                        <ul className="space-y-1 whitespace-nowrap">


                        </ul>
                    </div>

                    {/* Section: Build */}
                    <div className="flex flex-col gap-4">
                        <Link
                            href={route('mainproduct', { lang: i18n.language })}
                            className="text-xl text-black font-bold">{t('footer.products')}</Link>
                        <ul className="space-y-1 whitespace-nowrap">
                            <li><Link href={route('mainproduct', { lang: i18n.language })} className="hover:text-primary-color">
                                {t('mainproduct.title')}
                            </Link></li>


                        </ul>
                    </div>

                    {/* Section: Quick Links */}
                    <div className="flex flex-col gap-4">
                        {/* <h2 className="text-xl text-primary-color">{t('footer.quick_link')}</h2> */}
                        <ul className="space-y-1 whitespace-nowrap">
                            {Spotlight.map((item, index) => (

                                <li
                                    key={index}
                                ><Link href={route(item.href, { lang: i18n.language })}
                                    className="text-xl text-black font-bold"
                                >{item.title}</Link></li>
                            ))}

                        </ul>
                    </div>
                </div>
            </div>

            {/* Footer Bottom */}
            <div className="flex flex-col md:flex-row justify-between items-center gap-4 border-t border-gray-700 py-4 px-4 max-w-7xl mx-auto w-full">
                <div className="text-gray-400 text-sm text-center md:text-left">
                    {t('footer.copyright')} © {currentYear}
                </div>
                <div>
                    <a
                    href={site_setting || '#'}
                    rel="noopener noreferrer" target='__blank' className='hover:text-primary-color'>
                        {t('footer.maplocation')}

                    </a>
                </div>
                <div className="flex items-center gap-2 text-xs text-gray-400 text-center">
                    <a href="https://direct.me/dmcreators" target="_blank" rel="noopener noreferrer">
                        <img loading="lazy" src={mobawon} className="object-cover h-8" alt="Mobdwon" />
                    </a>
                    <span>
                        {t('footer.mobdwon')}
                        <a href="https://maps.app.goo.gl/vepPfgHWTj1e4L5z7?g_st=ic" target="_blank" rel="noopener noreferrer" className="hover:text-primary-color ml-1 ">
                            {t('footer.mobdwon_link')}
                        </a>
                    </span>
                </div>
            </div>
        </footer>
    )
}

export default Footer;
