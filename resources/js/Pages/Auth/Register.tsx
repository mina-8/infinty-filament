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
        last_name:'',
        email: '',
        phone:'',
        password: '',
        password_confirmation: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
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
                        <InputLabel htmlFor="name" value={t('reg_page.form.name')} className='w-[40%]'/>

                        <TextInput
                            id="name"
                            name="name"
                            value={data.name}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="name"
                            isFocused={true}
                            onChange={(e) => setData('name', e.target.value)}
                            required
                        />

                        <InputError message={errors.name} className="mt-2" />
                    </div>

                    <div
                    className='flex gap-12 items-center mt-4 lg:flex-row flex-col'
                    >
                        <InputLabel htmlFor="last_name" value={t('reg_page.form.last_name')}  className='w-[40%]'/>

                        <TextInput
                            id="last_name"
                            name="last_name"
                            value={data.last_name}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="last_name"
                            isFocused={true}
                            onChange={(e) => setData('last_name', e.target.value)}
                            required
                        />

                        <InputError message={errors.last_name} className="mt-2" />
                    </div>

                    <div className='flex gap-12 items-center mt-4 lg:flex-row flex-col'>
                        <InputLabel htmlFor="email" value={t('reg_page.form.email')} className='w-[40%]'/>

                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="username"
                            onChange={(e) => setData('email', e.target.value)}
                            required
                        />

                        <InputError message={errors.email} className="mt-2" />
                    </div>


                    <div
                    className='flex gap-12 items-center mt-4 lg:flex-row flex-col'
                    >
                        <InputLabel htmlFor="phone" value={t('reg_page.form.phone')}  className='w-[40%]'/>

                        <TextInput
                            id="phone"
                            name="phone"
                            value={data.phone}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="phone"
                            isFocused={true}
                            onChange={(e) => setData('phone', e.target.value)}
                            required
                        />

                        <InputError message={errors.phone} className="mt-2" />
                    </div>

                    <div
                    className='flex gap-12 items-center mt-4 lg:flex-row flex-col'
                    >
                        <InputLabel htmlFor="password" value={t('reg_page.form.password')} className='w-[40%]'/>

                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="new-password"
                            onChange={(e) => setData('password', e.target.value)}
                            required
                        />

                        <InputError message={errors.password} className="mt-2" />
                    </div>

                    <div
                    className='flex gap-12 items-center mt-4 lg:flex-row flex-col'
                    >
                        <InputLabel
                            htmlFor="password_confirmation"
                            value={t('reg_page.form.confirm_password')}
                            className='w-[40%]'
                        />

                        <TextInput
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            value={data.password_confirmation}
                            className="mt-1 block w-[60%] !rounded-2xl"
                            autoComplete="new-password"
                            onChange={(e) =>
                                setData('password_confirmation', e.target.value)
                            }
                            required
                        />

                        <InputError
                            message={errors.password_confirmation}
                            className="mt-2"
                        />
                    </div>

                    <div className="mt-4 flex items-center justify-end">
                        <Link
                            href={route('login')}
                            className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Already registered?
                        </Link>

                        <PrimaryButton className="ms-4 !bg-primary-color" disabled={processing}>
                            {t('reg_page.form.register')}
                        </PrimaryButton>
                    </div>
                </form>
            </section>
        </LangWraper>
    );
}
