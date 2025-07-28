import ImageZoomBox from '@/Components/ImageZoom/ImageZoomBox';
import StarRating from '@/Components/StarRating';
import { addtoCart, getCart, getCartItemQuantity, removeFormCart, toggelWishList } from '@/utils/cartUtils';
import { Head, Link } from '@inertiajs/react';
import { notification, Tooltip } from 'antd';
import React, { useState } from 'react'
import { useTranslation } from 'react-i18next';
import { IoIosHeartEmpty } from 'react-icons/io';
import { IoHomeSharp } from 'react-icons/io5';


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
    category_title: string;
    category_slug: string;
    subcategory_title?: string;
    subcategory_slug?: string;
}
interface props {
    product: ProductType;
}
const Index = ({ product }: props) => {
    const { t, i18n } = useTranslation();
    // filter option price
    const [selectedOptions, setSelectedOptions] = useState<{ [productId: number]: number }>({});

    // handel selected option price
    const handelOptionPrice = (productId: number, optionId: number) => {
        setSelectedOptions(prev => ({
            ...prev,
            [productId]: optionId
        }))
    }

    const SelectedOptionId = selectedOptions[product.id] || product.product_option[0].id;
    const filterOptionPrice = product.product_option.find(opt => opt.id === SelectedOptionId);

    const [api, contextHolder] = notification.useNotification();
    // state of cart item ui
    const [cartState, setCartState] = useState(getCart());

    const refreshCart = () => {
        setCartState(getCart());
    }

    const handelAddToCart = (productId: number, optionId: number, title: string, image: string, price: number) => {
        addtoCart(productId, optionId, title, image, price, 1);
        refreshCart();

        api['success']({
            message: '',
            description: `${t('notify.add_cart')}`

        })

    }

    const handelIncressCart = (productId: number, optionId: number, title: string, image: string, price: number) => {
        addtoCart(productId, optionId, title, image, price, 1);
        refreshCart();

        api['success']({
            message: '',
            description: `${t('notify.add_cart')}`

        })
    }

    const handelDecressCart = (productId: number, optionId: number) => {
        removeFormCart(productId, optionId, 1);
        refreshCart();

        api['success']({
            message: '',
            description: `${t('notify.remove_cart')}`

        })

    }

    const handelToggelWishList = (productId: number, title: string, image: string, optionId: number) => {
        toggelWishList(productId, title, image, optionId);

        api['success']({
            message: '',
            description: `${t('notify.wish_list')}`

        })
    }

    const getQuantity = (productId: number, optionId: number) => {
        return getCartItemQuantity(productId, optionId)
    }
    return (
        <>
            <Head title={product.title} />
            {contextHolder}
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
                        href={route('category', { lang: i18n.language, slug: product.category_slug })}
                        className='text-primary-color'
                    >
                        {product.category_title}
                    </Link>


                </div>
                {/* section of header title */}
                <section
                    className='lg:grid grid-cols-1 lg:grid-cols-[40%_1fr] gap-4 my-4 hidden'
                >
                    <div>
                        <ImageZoomBox image={product.main_image} images={product.images} />
                    </div>

                    <div
                    // className=' p-4 flex items-start gap-4 '
                    >
                        <div>
                            <h2
                                className='lg:text-3xl text-xl pb-4 font-bold border-b-2'
                            >{product.title}</h2>

                            <div
                                className='my-4 flex gap-12 items-center border-b-2 pb-4'
                            >
                                <div
                                    className='flex '
                                >
                                    <StarRating rating={product.rate} />
                                </div>

                                <div
                                    className='border-r-2 border-l-2 px-8 hover:text-primary-color cursor-pointer'
                                >
                                    {t('products.review')}
                                </div>

                                <p
                                    className='hover:text-primary-color cursor-pointer'
                                >
                                    {t('products.comment')}
                                </p>
                            </div>

                            {/* price */}
                            <div
                                className='font-medium text-4xl my-4 pb-4 border-b-2'
                            >
                                {filterOptionPrice?.price} KD
                            </div>

                            {/* code and available */}
                            <div
                                className='my-4 pb-4 border-b-2 flex flex-col'
                            >
                                <div
                                    className='flex gap-4 items-center my-2'
                                >
                                    <p>{t('products.product_code')}</p>
                                    :
                                    <p>{product.product_code}</p>
                                </div>
                                <div
                                    className='flex gap-4 items-center my-2'
                                >
                                    <p>{t('products.available')}</p>
                                    :
                                    <div>{product.avilable ?
                                        <p
                                            className='bg-primary-color p-2 rounded-lg text-white'
                                        > {t('products.no_stock')} </p>
                                        :
                                        <p
                                            className='bg-green-400 p-2 rounded-lg text-white'
                                        >
                                            {t('products.stock')}
                                        </p>
                                    }
                                    </div>
                                </div>

                            </div>

                            {/* selecet */}
                            <div
                                className=' rounded-lg p-4 bg-slate-200 flex flex-col gap-6'
                            >
                                <p
                                    className='lg:text-2xl font-bold text-xl'
                                >{t('products.select_price')}</p>

                                <div
                                    className='w-full'
                                >
                                    <select

                                        name='price'
                                        className={`rounded-xl focus:border-primary-color focus:ring-primary-color ${i18n.language == 'ar' ? '!pl-10 pr-2' : '!pr-10 pl-2'} w-full`}
                                        style={{
                                            backgroundPosition: `${i18n.language == 'ar' ? 'left' : 'right'}`
                                        }}
                                        defaultValue={product.product_option[0].title}
                                        onChange={(e) => handelOptionPrice(product.id, Number(e.target.value))}
                                    >
                                        {product.product_option.map((option, index) =>
                                            <option
                                                key={index}
                                                value={option.id}

                                            >
                                                {option.title} - ({option.price} KD)
                                            </option>
                                        )}
                                    </select>
                                </div>

                                {/* add to cart and wish list */}
                                <div
                                    className='flex w-full gap-4 flex-col lg:flex-row'
                                >
                                    {product.avilable ?


                                        (
                                            <button
                                                type='button'
                                                // onClick={() => handelAddToCart(product.id, SelectedOptionId, product.title, product.main_image, filterOptionPrice?.price ?? 0)}
                                                className='rounded-lg border-[1px] hover:bg-primary-color hover:text-white transition-all duration-300 border-primary-color px-4 py-2 cursor-not-allowed'
                                            >
                                                {t('exhibition.add_to_cart')}
                                            </button>
                                        )
                                        :

                                        getQuantity(product.id, SelectedOptionId) === 0 ?

                                            (
                                                <button
                                                    type='button'
                                                    onClick={() => handelAddToCart(product.id, SelectedOptionId, product.title, product.main_image, filterOptionPrice?.price ?? 0)}
                                                    className='rounded-lg border-[1px] hover:bg-primary-color hover:text-white transition-all duration-300 border-primary-color px-4 py-2'
                                                >
                                                    {t('exhibition.add_to_cart')}
                                                </button>
                                            )
                                            :
                                            (
                                                <div
                                                    className='flex justify-between items-center gap-4'
                                                >
                                                    <button
                                                        type='button'
                                                        onClick={() => handelIncressCart(product.id, SelectedOptionId, product.title, product.main_image, filterOptionPrice?.price ?? 0)}
                                                        className='rounded-lg  bg-primary-color text-white text-center px-4 py-2'
                                                    >
                                                        +
                                                    </button>

                                                    <span className="font-medium">
                                                        {getQuantity(product.id, SelectedOptionId)}
                                                    </span>

                                                    <button
                                                        type='button'
                                                        onClick={() => handelDecressCart(product.id, SelectedOptionId)}
                                                        className='rounded-lg bg-primary-color text-white text-center px-4 py-2'
                                                    >
                                                        -
                                                    </button>
                                                </div>
                                            )


                                    }

                                    <button
                                        type='button'
                                        onClick={() => handelToggelWishList(product.id, product.title, product.main_image, SelectedOptionId)}
                                        className='rounded-lg border-[1px] hover:bg-primary-color hover:text-white transition-all duration-300 border-primary-color px-4 py-2 text-lg'
                                    >
                                        <Tooltip title={t('exhibition.wich_list')} >
                                            <IoIosHeartEmpty />
                                        </Tooltip>
                                    </button>
                                </div>
                            </div>
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
                        {/* <div
                        className='flex items-center gap-4'
                    >
                        {category.subcategory.map((item, index) =>
                            <Link
                                href={route('subcategory', { lang: i18n.language, category: category.slug, subcategory: item.slug })}
                                className='border-[1px] p-2 rounded-lg hover:text-primary-color'
                            >
                                {`${item.title} (${item.product_count})`}
                            </Link>
                        )}

                    </div> */}

                        <div
                            className='border-[1px] px-4 py-2 rounded-lg'
                        >
                            <div
                                className='flex gap-4 items-center'
                            >
                                {/* <button
                                type='button'
                                onClick={() => setGridView(false)}
                            >
                                <FaList size={24} />
                            </button>
                            <button
                                type='button'
                                onClick={() => setGridView(true)}
                            >
                                <RiLayoutGrid2Fill size={24} />
                            </button> */}
                            </div>
                        </div>

                        {/* products show grid or flex */}
                        <div
                        // className={`${GridView ? 'grid grid-cols-1 lg:grid-cols-3 gap-6' : 'flex flex-col gap-6'}`}
                        >
                            {/* {GridView ?
                            <GridCard products={category.all_products.data} />
                            :
                            <FlexCard products={category.all_products.data} />
                        } */}
                        </div>

                    </div>

                </section>
            </section>
        </>
    )
}

export default Index