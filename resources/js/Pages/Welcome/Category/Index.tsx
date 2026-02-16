import ContentRenderer from '@/Components/ContentRenderer';
import FlexCard from '@/Components/FlexCard';
import GridCard from '@/Components/GridCard';
import { PageProps } from '@/types';
import { GridToggel, setFlexLayout, setGridLayout } from '@/utils/GridUtils';
import { Link, usePage } from '@inertiajs/react';
import React, { useState } from 'react'
import { useTranslation } from 'react-i18next';
import { FaList } from 'react-icons/fa';
import { IoHomeSharp } from 'react-icons/io5';
import { RiLayoutGrid2Fill } from 'react-icons/ri';

export interface ProductOption {
    id: number;
    title: string;
    price: number;
}
export interface ProductType {
    id: number;
    title: string;
    content: string;
    product_code: string;
    avilable: boolean;
    state: string;
    rate: number;
    main_image: string;
    images: string[];
    product_option: ProductOption[];
    slug: string;
}

export interface PaginationMeta {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

export interface PaginatedProducts {
    data: ProductType[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}
export interface SubCategory {
    id: number;
    title: string;
    content: string;
    image: string;
    product_count: number;
    slug: string;
}
export interface Category {
    id: number;
    title: string;
    content: string;
    image: string;
    subcategory: SubCategory[]
    all_products: PaginatedProducts;
    slug: string;
}
interface props {
    category: Category;
}

interface CustomProp extends PageProps {
    categories: Category[];
}
const Index = ({ category }: props) => {
    const { t, i18n } = useTranslation();
    const [GridView, setGridView] = useState(GridToggel());
    const { categories } = usePage<CustomProp>().props
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
                <Link
                    href={route('category', { lang: i18n.language, slug: category.slug })}
                    className='text-primary-color'
                >
                    {category.title}
                </Link>


            </div>
            {/* section of header title */}
            <section
                className='lg:grid grid-cols-1 lg:grid-cols-[20%_1fr] gap-4 my-4 hidden'
            >
                <div
                    className='flex flex-col  border-2 rounded-lg overflow-hidden '
                >
                    <div
                        className='bg-black text-white px-4 py-2'
                    >
                        {t('products.category')}
                    </div>
                    <div
                        className='flex items-start flex-col'
                    >
                        {categories.map((item, index) =>
                            <Link
                            key={index}
                                href={route('category', { lang: i18n.language, slug: item.slug })}
                                className='px-4 py-2 hover:text-primary-color'
                            >
                                {item.title}
                            </Link>
                        )}

                    </div>
                </div>


                <div
                    className='border-2 p-4 flex items-center gap-4 rounded-lg '
                >
                    <div>
                        <h2
                            className='text-2xl pb-2'
                        >{category.title}</h2>
                        <img src={category.image} alt={category.title} className='object-contain h-24 rounded-lg' />
                    </div>
                    <div>
                        <ContentRenderer content={category.content} />
                    </div>
                </div>
            </section>

            {/* section of subcateogry and products */}
            <section
                className='grid grid-cols-1 lg:grid-cols-[20%_1fr] gap-4 my-4'
            >
                <div></div>

                <div
                    className='flex flex-col gap-4'
                >
                    <div
                        className='flex items-center gap-4 mx-4 lg:mx-0 flex-wrap lg:flex-nowrap'
                    >
                        {category.subcategory.map((item, index) =>
                            <Link
                                key={index}
                                href={route('subcategory', { lang: i18n.language, category: category.slug, subcategory: item.slug })}
                                className='border-[1px] p-2 rounded-lg hover:text-primary-color'
                            >
                                {`${item.title} (${item.product_count})`}
                            </Link>
                        )}

                    </div>

                    <div
                        className='border-[1px] px-4 py-2 rounded-lg'
                    >
                        <div
                            className='flex gap-4 items-center'
                        >
                            <button
                                type='button'
                                onClick={() => setGridView(setFlexLayout())}
                            >
                                <FaList size={24} />
                            </button>
                            <button
                                type='button'
                                onClick={() => setGridView(setGridLayout())}
                            >
                                <RiLayoutGrid2Fill size={24} />
                            </button>
                        </div>
                    </div>

                    {/* products show grid or flex */}
                    <div
                        className={`${GridView ? 'grid grid-cols-1 lg:grid-cols-3 gap-6' : 'flex flex-col gap-6'} mx-4 my-4 lg:mx-0 lg:my-0 `}
                    >

                        {GridView ?
                            <GridCard page='category' category_slug={category.slug} products={category.all_products.data} />
                            :
                            <FlexCard page='category' category_slug={category.slug} products={category.all_products.data} />
                        }
                    </div>

                </div>

            </section>
        </section>
    )
}

export default Index