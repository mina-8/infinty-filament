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
            <h2 className="text-3xl text-center font-bold text-primary-color ">
                {t("blog.title")}
            </h2>
            <p>{t("blog.content")}</p>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 px-4 lg:px-0 w-full">
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
                            <div className="p-4 flex flex-col gap-2  ">
                                <h3 className="text-xl font-semibold text-primary-color ">
                                    {blog.title}
                                </h3>

                                <Link
                                    href={route("blog-show", {
                                        lang: i18n.language,
                                        slug: blog.slug,
                                    })}
                                    className="mt-2 text-white bg-primary-color rounded-md p-4 text-center shadow-md hover:shadow hover:bg-secondary-color"
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
