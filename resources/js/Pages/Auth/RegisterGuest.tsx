import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import LangWraper from '@/Layouts/LangWraper';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import { useTranslation } from 'react-i18next';
import { IoHomeSharp } from 'react-icons/io5';

export default function Register() {
    const { t, i18n } = useTranslation()
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        phone: '',
        area: '',
        street: '',
        block: '',
        building: '',
        complex: '',
        floore_number: '',
        flate_number: '',
        land_mark: ''
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('register-guest'), {
            onFinish: () => reset('name', 'email', 'phone', 'area', 'street', 'block', 'building', 'complex', 'floore_number', 'flate_number', 'land_mark'),
        });
    };

    return (
        <LangWraper>
            <section
                className='min-h-screen max-w-7xl mx-auto'
            >
                <Head title="Register" />
                <div
                    className='h-48'
                ></div>
                <div className='bg-slate-300 p-2 rounded-lg flex items-center gap-6 px-6 '>
                    <Link
                        href={route('welcome', { lang: i18n.language })}
                    >
                        <IoHomeSharp />
                    </Link>


                </div>
                <div
                    className='my-4'
                >
                    <h2
                        className='border-b-2 pb-2 font-bold'
                    >{t('reg_page.register_title')}</h2>
                    <div
                        className='py-2'
                    >{t('reg_page.register_content')}</div>
                    <p
                        className='border-b-2 pb-2 font-bold'
                    >{t('reg_page.register_details')}</p>
                </div>
                <form onSubmit={submit}>
                    <div
                        className='flex gap-12 items-center lg:flex-row flex-col'
                    >
                        <InputLabel htmlFor="name" value={t('reg_page.form.name')} className='w-[40%]' />

                        <TextInput
                            id="name"
                            name="name"
                            value={data.name}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="name"
                            isFocused={true}
                            onChange={(e) => setData('name', e.target.value)}
                            required
                            placeholder={t('reg_page.form.name')}
                        />

                        <InputError message={errors.name} className="mt-2" />
                    </div>


                    <div className='flex gap-12 items-center mt-4 lg:flex-row flex-col'>
                        <InputLabel htmlFor="email" value={t('reg_page.form.email')} className='w-[40%]' />

                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="username"
                            onChange={(e) => setData('email', e.target.value)}
                            required
                            placeholder={t('reg_page.form.email')}
                        />

                        <InputError message={errors.email} className="mt-2" />
                    </div>


                    <div
                        className='flex gap-12 items-center mt-4 lg:flex-row flex-col'
                    >
                        <InputLabel htmlFor="phone" value={t('reg_page.form.phone')} className='w-[40%]' />

                        <div
                        className='w-[60%] flex items-center'
                        >
                            <span
                                className={`border-2 py-2 px-2 mt-1 rounded-s-2xl ${i18n.language == 'ar' ? 'border-l-0' : 'border-r-0'} `}
                            >+966</span>
                            <TextInput
                                id="phone"
                                name="phone"
                                value={data.phone}
                                className="mt-1 block w-full !rounded-none !rounded-e-2xl"
                                autoComplete="phone"
                                isFocused={true}
                                onChange={(e) => setData('phone', e.target.value)}
                                required
                                placeholder={t('reg_page.form.phone')}
                            />
                        </div>

                        <InputError message={errors.phone} className="mt-2" />
                    </div>

                    <div
                        className='flex gap-12 items-center lg:flex-row flex-col mt-4'
                    >
                        <InputLabel htmlFor="area" value={t('reg_page.form.area')} className='w-[40%]' />

                        <TextInput
                            id="area"
                            name="area"
                            value={data.area}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="area"
                            isFocused={true}
                            onChange={(e) => setData('area', e.target.value)}
                            required
                            placeholder={t('reg_page.form.area')}
                        />

                        <InputError message={errors.area} className="mt-2" />
                    </div>

                    <div
                        className='flex gap-12 items-center lg:flex-row flex-col mt-4'
                    >
                        <InputLabel htmlFor="area" value={t('reg_page.form.street')} className='w-[40%]' />

                        <TextInput
                            id="street"
                            name="street"
                            value={data.street}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="street"
                            isFocused={true}
                            onChange={(e) => setData('street', e.target.value)}
                            required
                            placeholder={t('reg_page.form.street')}
                        />

                        <InputError message={errors.street} className="mt-2" />
                    </div>

                    <div
                        className='flex gap-12 items-center lg:flex-row flex-col mt-4'
                    >
                        <InputLabel htmlFor="block" value={t('reg_page.form.block')} className='w-[40%]' />

                        <TextInput
                            id="block"
                            name="block"
                            value={data.block}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="block"
                            isFocused={true}
                            onChange={(e) => setData('block', e.target.value)}
                            required
                            placeholder={t('reg_page.form.block')}
                        />

                        <InputError message={errors.block} className="mt-2" />
                    </div>

                    <div
                        className='flex gap-12 items-center lg:flex-row flex-col mt-4'
                    >
                        <InputLabel htmlFor="building" value={t('reg_page.form.building')} className='w-[40%]' />

                        <TextInput
                            id="building"
                            name="building"
                            value={data.building}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="building"
                            isFocused={true}
                            onChange={(e) => setData('building', e.target.value)}
                            required
                            placeholder={t('reg_page.form.building')}
                        />

                        <InputError message={errors.building} className="mt-2" />
                    </div>

                    <div
                        className='flex gap-12 items-center lg:flex-row flex-col mt-4'
                    >
                        <InputLabel htmlFor="complex" value={t('reg_page.form.complex')} className='w-[40%]' />

                        <TextInput
                            id="complex"
                            name="complex"
                            value={data.complex}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="complex"
                            isFocused={true}
                            onChange={(e) => setData('complex', e.target.value)}
                            placeholder={t('reg_page.form.complex')}

                        />

                        <InputError message={errors.complex} className="mt-2" />
                    </div>

                    <div
                        className='flex gap-12 items-center lg:flex-row flex-col mt-4'
                    >
                        <InputLabel htmlFor="floore_number" value={t('reg_page.form.floore_number')} className='w-[40%]' />

                        <TextInput
                            id="floore_number"
                            name="floore_number"
                            value={data.floore_number}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="floore_number"
                            isFocused={true}
                            onChange={(e) => setData('floore_number', e.target.value)}
                            placeholder={t('reg_page.form.floore_number')}
                        />

                        <InputError message={errors.floore_number} className="mt-2" />
                    </div>

                    <div
                        className='flex gap-12 items-center lg:flex-row flex-col mt-4'
                    >
                        <InputLabel htmlFor="flate_number" value={t('reg_page.form.flate_number')} className='w-[40%]' />

                        <TextInput
                            id="flate_number"
                            name="flate_number"
                            value={data.flate_number}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="flate_number"
                            isFocused={true}
                            onChange={(e) => setData('flate_number', e.target.value)}
                            placeholder={t('reg_page.form.flate_number')}
                        />

                        <InputError message={errors.flate_number} className="mt-2" />
                    </div>

                    <div
                        className='flex gap-12 items-center lg:flex-row flex-col mt-4'
                    >
                        <InputLabel htmlFor="land_mark" value={t('reg_page.form.land_mark')} className='w-[40%]' />

                        <TextInput
                            id="land_mark"
                            name="land_mark"
                            value={data.land_mark}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="land_mark"
                            isFocused={true}
                            onChange={(e) => setData('land_mark', e.target.value)}
                            placeholder={t('reg_page.form.land_mark')}
                        />

                        <InputError message={errors.land_mark} className="mt-2" />
                    </div>


                    <div className="mt-4 flex items-center justify-end">

                        <PrimaryButton className="ms-4 !bg-primary-color" disabled={processing}>
                            {t('reg_page.form.register')}
                        </PrimaryButton>
                    </div>
                </form>
            </section>
        </LangWraper>
    );
}
