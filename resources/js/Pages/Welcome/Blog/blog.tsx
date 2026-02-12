import { Link } from "@inertiajs/react";
import { useTranslation } from "react-i18next";
interface Props {
    blogs: {
        id: number;
        title: string;
        content: string;
        slug: string;
        image: string;
    }[];
}
const Blog = ({ blogs }: Props) => {
    const { t, i18n } = useTranslation();
    return (
        <section className="my-8 flex flex-col items-center justify-center gap-4 w-full max-w-7xl mx-auto">
            <div className="self-start">
                <div className="flex">
                    <h2 className="text-3xl self-center lg:self-start font-bold text-primary-color hover:bg-primary-color hover:text-third-color p-2 hover:rounded-full transition-all duration-500">
                        {t("blog.title")}
                    </h2>
                </div>
                <p>{t("blog.content")}</p>
            </div>
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 px-4 lg:px-0">
                {blogs.length > 0 &&
                    blogs.map((blog) => (
                        <div
                            key={blog.id}
                            className="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            <img
                                src={blog.image}
                                alt={blog.title}
                                className="w-full h-48 object-cover"
                            />
                            <div className="p-4 flex flex-col gap-2 group hover:bg-primary-color hover:text-white">
                                <h3 className="text-xl font-semibold text-primary-color group-hover:text-white">
                                    {blog.title}
                                </h3>

                                <Link
                                    href={route("blog-show", {
                                        lang: i18n.language,
                                        slug: blog.slug,
                                    })}
                                    className="mt-2 text-third-color bg-primary-color rounded-md p-4 text-center shadow-md hover:shadow group-hover:bg-transparent group-hover:border-third-color border-2 border-transparent"
                                >
                                    {t("blog.read_more")}
                                </Link>
                            </div>
                        </div>
                    ))}
            </div>
        </section>
    );
};

export default Blog;