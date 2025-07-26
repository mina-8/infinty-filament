import { Transition } from '@headlessui/react';
import { InertiaLinkProps, Link } from '@inertiajs/react';
import {
    createContext,
    Dispatch,
    PropsWithChildren,
    SetStateAction,
    useContext,
    useState,
} from 'react';

type TriggerType = 'hover' | 'click' | 'both';

const DropDownContext = createContext<{
    open: boolean;
    setOpen: Dispatch<SetStateAction<boolean>>;
    toggleOpen: () => void;
}>({
    open: false,
    setOpen: () => {},
    toggleOpen: () => {},
});

interface DropdownProps extends PropsWithChildren {
    triggerType?: TriggerType;
}

const Dropdown = ({ children, triggerType = 'hover' }: DropdownProps) => {
    const [open, setOpen] = useState(false);

    const toggleOpen = () => setOpen((prev) => !prev);

    const handleMouseEnter = () => {
        if (triggerType === 'hover' || triggerType === 'both') {
            setOpen(true);
        }
    };

    const handleMouseLeave = () => {
        if (triggerType === 'hover' || triggerType === 'both') {
            setOpen(false);
        }
    };

    const handleClick = () => {
        if (triggerType === 'click' || triggerType === 'both') {
            toggleOpen();
        }
    };

    return (
        <DropDownContext.Provider value={{ open, setOpen, toggleOpen }}>
            <div
                className="relative"
                onMouseEnter={handleMouseEnter}
                onMouseLeave={handleMouseLeave}
                onClick={handleClick}
            >
                {children}
            </div>
        </DropDownContext.Provider>
    );
};

const Trigger = ({ children }: PropsWithChildren) => {
    return <div className="cursor-pointer">{children}</div>;
};

const Content = ({
    align = 'right',
    width = 'w-auto', // ✅ الآن يمكنك تمرير أي class للعرض
    contentClasses = 'py-1 bg-white',
    positionClasses, // ✅ خيار جديد لوضعه في أي مكان بحرية
    children,
}: PropsWithChildren<{
    align?: 'left' | 'right' | 'center';
    width?: string; // ✅ مرن (يمكن تمرير أي Tailwind width)
    contentClasses?: string;
    positionClasses?: string; // ✅ يسمح بوضع مخصص
}>) => {
    const { open } = useContext(DropDownContext);

    let alignmentClasses = '';
    if (!positionClasses) {
        if (align === 'left') {
            alignmentClasses = 'ltr:origin-top-left rtl:origin-top-right start-0';
        } else if (align === 'right') {
            alignmentClasses = 'ltr:origin-top-right rtl:origin-top-left end-0';
        } else if (align === 'center') {
            alignmentClasses = 'left-1/2 -translate-x-1/2 origin-top';
        }
    } else {
        alignmentClasses = positionClasses; // ✅ استخدام position مخصص
    }

    return (
        <Transition
            show={open}
            enter="transition ease-out duration-200"
            enterFrom="opacity-0 scale-95"
            enterTo="opacity-100 scale-100"
            leave="transition ease-in duration-75"
            leaveFrom="opacity-100 scale-100"
            leaveTo="opacity-0 scale-95"
        >
            <div
                className={`absolute z-50 mt-2 rounded-md shadow-lg ${alignmentClasses} ${width}`}
            >
                <div
                    className={`rounded-md ring-1 ring-black ring-opacity-5 ${contentClasses}`}
                >
                    {children}
                </div>
            </div>
        </Transition>
    );
};

const DropdownLink = ({
    className = '',
    children,
    ...props
}: InertiaLinkProps) => {
    return (
        <Link
            {...props}
            className={
                'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none ' +
                className
            }
        >
            {children}
        </Link>
    );
};

Dropdown.Trigger = Trigger;
Dropdown.Content = Content;
Dropdown.Link = DropdownLink;

export default Dropdown;
