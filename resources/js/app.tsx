import '../css/app.css';
import './bootstrap';
import '../js/I18n/i18n'
import 'react-quill/dist/quill.snow.css';
import { createInertiaApp, router } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import AuthLayout from './Layouts/AuthLayout';
import LanguageContext from './Layouts/LanguageContext';
import { useEffect, useState } from 'react';
import Loading from './Components/Loading';



const appName = import.meta.env.VITE_APP_NAME || 'Orca Shop';

createInertiaApp({
    title: (title) => `${appName} - ${title}`,

    resolve: (name) => resolvePageComponent(
        `./Pages/${name}.tsx`,
        import.meta.glob('./Pages/**/*.tsx'),
    ).then((module: any) => {
        const page = module.default;
        page.layout = page.layout || ((page: any) => <AuthLayout>{page}</AuthLayout>);
        return module;
    }
    ),
    setup({ el, App, props }) {
        const root = createRoot(el);
        const RootApp = () => {
            const [loading, setLoading] = useState(false);
            const [showLoading, setShowLoading] = useState(false);
            useEffect(() => {

                router.on('start', () => {
                    setLoading(true)
                    setShowLoading(true)
                });
                router.on('finish', () => {
                    setLoading(false)
                    setTimeout(() => {
                        setShowLoading(false)
                    }, 2500); // Delay to show loading state
                } );
            }, []);
            return (
                <LanguageContext>
                    {showLoading && <Loading loading={loading} />}
                    <App {...props} />
                </LanguageContext>

            )
        }
        root.render(<RootApp />);
    },
    progress: {
        color: '#4B5563',
    },
});
