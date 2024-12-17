import useTranslate from '@/shared/hooks/useTranslate'
import { Button } from '@/Components/_Base/Button'
import { PlusCircleIcon, TrashIcon } from '@heroicons/react/24/outline'
import { Link } from '@inertiajs/react'
import { PencilIcon } from '@heroicons/react/24/solid'

interface FamilyFormProps {
    data?: any
}

export function FamilyForm(props: FamilyFormProps) {
    const __ = useTranslate()

    return (
        <div className="w-full gap-8 flex flex-col mb-8">
            <div className="space-y-4 flex flex-col h-full flex-1 min-h-0">
                <ol className="space-y-4 flex-1 pt-2 overflow-y-auto">
                    <li key="primary">
                        <p className="flex justify-between py-2.5 px-3.5 bg-ceiling rounded-md shadow">
                            <span>
                                {
                                    props.data.members.find(
                                        (m: any) => m.is_primary,
                                    )?.name
                                }
                            </span>
                            <span className="text-gray-500">You</span>
                        </p>
                    </li>
                    {props.data.members
                        .filter((m) => !m.is_primary)
                        .map((m) => (
                            <li key={m.id}>
                                <p className="flex justify-between items-center px-3.5 bg-ceiling rounded-md shadow h-11">
                                    <span>{m.name}</span>
                                    <div className="flex gap-4 items-center">
                                        <span className="text-gray-500">
                                            {__(
                                                ('self_disclosure.family_members.' +
                                                    (m.familyable.type
                                                        ? m.familyable.type
                                                        : m.age < 18
                                                          ? 'child'
                                                          : 'adult')) as TranslationKey,
                                            )}
                                        </span>
                                        <div className="flex gap-1">
                                            <Link
                                                className="text-interactive p-2"
                                                href={route(
                                                    'self-disclosure.family-members.edit',
                                                    m.id,
                                                )}
                                            >
                                                <PencilIcon className="size-5" />
                                            </Link>
                                            <Link
                                                method="delete"
                                                as="button"
                                                className="text-interactive p-2"
                                                href={route(
                                                    'self-disclosure.family-members.destroy',
                                                    m.id,
                                                )}
                                            >
                                                <TrashIcon className="size-5" />
                                            </Link>
                                        </div>
                                    </div>
                                </p>
                            </li>
                        ))}
                </ol>

                <Button
                    href={route('self-disclosure.family-members.create')}
                    type="button"
                    color="secondary"
                    size="lg"
                    className="w-full gap-2"
                >
                    <PlusCircleIcon className="size-5" />
                    <span>
                        {__('general.button.add', {
                            resource: 'general.resources.family_member',
                        })}
                    </span>
                </Button>
            </div>

            <Button
                className="w-full"
                href={route('self-disclosure.address.show')}
            >
                {__('general.button.continue')}
            </Button>
        </div>
    )
}
