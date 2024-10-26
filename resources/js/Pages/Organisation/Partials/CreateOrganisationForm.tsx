import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Transition} from '@headlessui/react';
import {useForm} from '@inertiajs/react';
import {FormEventHandler, useEffect, useRef, useState} from 'react';

export default function CreateOrganisationForm({
                                                   domain,
                                                   className = '',
                                               }: {
    className?: string;
    domain: string;
}) {
    const nameInput = useRef<HTMLInputElement>(null);
    const subdomainInput = useRef<HTMLInputElement>(null);

    const [subdomainTouched, setSubdomainTouched] = useState(false)

    const {
        data,
        setData,
        errors,
        post,
        reset,
        processing,
        recentlySuccessful,
    } = useForm({
        name: '',
        subdomain: ''
    });

    useEffect(() => {
        if (!subdomainTouched || !data.subdomain) {
            setData('subdomain', data.name.toLowerCase().replace(/[\s_]/g, "-").replace(/-{2,}/g, "-"))
        }
    }, [data.name]);

    const createOrganisationHandler: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('organisation.store'), {
            preserveScroll: true,
            onSuccess: () => reset(),
            onError: (errors) => {
                if (errors.name) {
                    nameInput.current?.focus();
                }
                if (errors.domain) {
                    subdomainInput.current?.focus();
                }
            },
        });
    };

    return (
        <section className={className}>
            <header>
                <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Organisation Basics
                </h2>

                <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Ensure your account is using a long, random password to stay
                    secure.
                </p>
            </header>

            <form onSubmit={createOrganisationHandler} className="mt-6 space-y-6">
                <div>
                    <InputLabel
                        htmlFor="name"
                        value="What is the name of your organisation?"
                    />

                    <TextInput
                        id="name"
                        ref={nameInput}
                        value={data.name}
                        maxLength={255}
                        onChange={(e) =>
                            setData('name', e.target.value)
                        }
                        type="text"
                        className="mt-1 block w-full"
                    />

                    <InputError
                        message={errors.name}
                        className="mt-2"
                    />
                </div>

                <div>
                    <InputLabel
                        htmlFor="name"
                        value="What should be the URL?"
                    />

                    <TextInput
                        id="subdomain"
                        ref={subdomainInput}
                        value={data.subdomain}
                        maxLength={120}
                        append={`.${domain}`}
                        onChange={(e) => {
                            setData('subdomain', e.target.value.toLowerCase().replace(/[\s_]/g, "-").replace(/-{2,}/g, "-"))
                            setSubdomainTouched(true)
                        }
                        }
                        onBlur={(e) => setData('subdomain', e.target.value.toLowerCase().replace(/-$/, ""))}
                        type="text"
                        className="mt-1 block w-full"
                    />

                    <InputError
                        message={errors.subdomain}
                        className="mt-2"
                    />
                </div>

                <div className="flex items-center gap-4">
                    <PrimaryButton disabled={processing}>Save</PrimaryButton>

                    <Transition
                        show={recentlySuccessful}
                        enter="transition ease-in-out"
                        enterFrom="opacity-0"
                        leave="transition ease-in-out"
                        leaveTo="opacity-0"
                    >
                        <p className="text-sm text-gray-600 dark:text-gray-400">
                            Saved.
                        </p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
