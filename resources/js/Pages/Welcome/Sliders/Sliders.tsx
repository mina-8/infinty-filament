import { Button, Carousel, ConfigProvider } from 'antd'
import React, { useState } from 'react'

import slideone from '../../../../../public/sliders/slide (1).webp'

import { useTranslation } from 'react-i18next'
import { Link } from '@inertiajs/react'

import { FaArrowLeft, FaArrowRight } from 'react-icons/fa'

import ContentRenderer from '@/Components/ContentRenderer'

interface Slides {
    id: number;
    title: string;
    content: string;
    image: string;
    active_btn:string;
    str_btn: string;
    link: string;
}

interface Props {
    slides: Slides[]
}
export default function Sliders({ slides }: Props) {


    const { t, i18n } = useTranslation();

    const [AcitveIndex, setActiveIndex] = useState(0);

    const HandelActiveIndex = (current: number, next: number) => {
        setActiveIndex(next)
    }


    const CustomArrow = ({ direction, onClick }: any) => {
        const ArrowIcon = direction === 'prev' ? FaArrowLeft : FaArrowRight;
        return (
            <div
                className="flex items-center justify-center w-12 h-12 rounded-full border-2 border-white shadow-lg cursor-pointer transition hover:bg-custom-dark-blue group"
                style={{
                    position: 'absolute',
                    top: '50%',
                    transform: 'translateY(-50%)',
                    zIndex: 1,
                    [direction === 'prev' ? 'left' : 'right']: '10px',
                }}
                onClick={onClick}
            >
                <ArrowIcon className="text-custom-dark-blue group-hover:text-white text-2xl text-yellow-original" />
            </div>
        );
    };

    const images = [
        slideone
    ];

    return (
        <div className='flex justify-center items-center flex-col '>
            <div className='w-full'>
                {slides?.length > 0 ?
                    <ConfigProvider
                        theme={{
                            components: {
                                Carousel: {
                                    dotHeight: 20,
                                    dotWidth: 20,
                                    dotActiveWidth: 20,

                                },
                            },
                        }}
                    >
                        <Carousel
                            arrows
                            // autoplay
                            infinite
                            className="custom-carousel-dots"
                            beforeChange={HandelActiveIndex}
                            prevArrow={<CustomArrow direction="prev" />}
                            nextArrow={<CustomArrow direction="next" />}
                        >

                            {slides.map((item, index) =>
                                <div key={item.id}
                                    className='relative'
                                >
                                    <div

                                        style={{
                                            height: '550px',

                                            backgroundImage: `url('${item.image}')`,
                                            // backgroundSize: 'cover',
                                            // backgroundPosition: 'center',
                                        }}
                                        className='relative bg-no-repeat  bg-center bg-cover w-full'
                                    >


                                        <div
                                            className={`flex flex-col ${i18n.language === 'ar' ? 'items-end' : 'items-start'} px-24 justify-center gap-2 h-full overflow-hidden`}
                                        >

                                            {/* <div className='absolute w-full h-full bg-black top-0 right-0 opacity-50'></div> */}

                                            <p
                                                className={`pt-20 text-4xl text-white drop-shadow-3xl xs:text-xl
                                                ${AcitveIndex === index ? i18n.language == 'ar' ? 'animate-faderight' : 'animate-fadeleft' : ''}`}
                                            >{item.title}</p>

                                            <div
                                            className={`py-5 text-3xl  font-bold text-black drop-shadow-3xl xs:text-base xs:text-center
                                             ${AcitveIndex === index ? i18n.language == 'ar' ? 'animate-faderight' : 'animate-fadeleft' : ''}`}
                                                style={{
                                                    animationDuration: "1s",
                                                    animationDelay: "0.75s"
                                                }}
                                            >
                                                <ContentRenderer content={item.content} />
                                            </div>

                                            {
                                                AcitveIndex === index &&

                                                <div className='flex justify-between items-center gap-4 mt-12 xs:flex-col'>
                                                    {item.active_btn && (


                                                    <a
                                                        href={item.link}
                                                        className={`${AcitveIndex === index ? i18n.language == 'ar' ? 'animate-faderight' : 'animate-fadeleft' : ''} bg-primary-color text-white px-4 py-2 rounded-lg hover:bg-black hover:text-white`}
                                                        style={{
                                                            animationDuration: "1s",
                                                            animationDelay: "1.5s"
                                                        }}
                                                    >
                                                        <div className='text-xl'>{item.str_btn}</div>
                                                    </a>
                                                    )}

                                                </div>

                                            }
                                        </div>
                                    </div>
                                </div>
                            )}
                        </Carousel>
                    </ConfigProvider>
                    :

                    <ConfigProvider
                        theme={{
                            components: {
                                Carousel: {
                                    dotHeight: 20,
                                    dotWidth: 20,
                                    dotActiveWidth: 20,

                                },
                            },
                        }}
                    >
                        <Carousel
                            arrows
                            infinite
                            autoplay
                            beforeChange={HandelActiveIndex}
                            prevArrow={<CustomArrow direction="prev" />}
                            nextArrow={<CustomArrow direction="next" />}
                        >

                            {images.map((item, index) =>
                                <div key={index} className='relative'>
                                    <div
                                        style={{
                                            height: '550px',
                                            backgroundImage: `url('${item}')`,
                                            backgroundSize: 'cover',
                                            backgroundPosition: 'center',
                                        }}
                                        className='relative'
                                    >
                                        {/* <div className='absolute w-full h-full bg-black top-0 right-0 opacity-50'></div> */}
                                        <div className={`flex flex-col ${i18n.language === 'ar' ? 'items-end' : 'items-start'} px-24 justify-center gap-2 h-full overflow-hidden`}>
                                            <p
                                                className={`pt-20 text-6xl text-black drop-shadow-3xl xs:text-xl
                                                ${AcitveIndex === index ? i18n.language == 'ar' ? 'animate-faderight' : 'animate-fadeleft' : ''}`}>
                                                {/* {t(`slides.title_${index + 1}`)} */}
                                            </p>

                                            <p className={`py-5 text-3xl  font-bold text-black drop-shadow-3xl xs:text-base xs:text-center
                                             ${AcitveIndex === index ? i18n.language == 'ar' ? 'animate-faderight' : 'animate-fadeleft' : ''}`}
                                                style={{
                                                    animationDuration: "1s",
                                                    animationDelay: "0.75s"
                                                }}
                                            >
                                                {/* {t(`slides.description_${index + 1}`)} */}
                                                </p>

                                            {
                                                AcitveIndex === index &&

                                                <div className='flex justify-between items-center gap-4 mt-12 xs:flex-col'>
                                                    <Link
                                                        href={route(`welcome`, { lang: i18n.language })}
                                                        className={`${AcitveIndex === index ? i18n.language == 'ar' ? 'animate-faderight' : 'animate-fadeleft' : ''} bg-primary-color text-white p-4 rounded-lg`}
                                                        style={{
                                                            animationDuration: "1s",
                                                            animationDelay: "1.5s"
                                                        }}
                                                    >
                                                        <div className={`flex items-center justify-center ${i18n.language === 'ar' ? 'flex-row' : 'flex-row-reverse'} w-full relative z-10`}>
                                                            <div className={`flex items-center w-10 h-10 ${i18n.language === 'ar' ? '' : 'justify-end'}`}>
                                                                {i18n.language === 'ar' ? <FaArrowLeft /> : <FaArrowRight />}

                                                            </div>
                                                            <div className='ml-2 text-xl'>{t(`slides.button_${index + 1}`)}</div>
                                                        </div>
                                                    </Link>

                                                </div>

                                            }


                                        </div>
                                    </div>
                                </div>
                            )}
                        </Carousel>
                    </ConfigProvider>
                }
            </div>

        </div>
    )
}