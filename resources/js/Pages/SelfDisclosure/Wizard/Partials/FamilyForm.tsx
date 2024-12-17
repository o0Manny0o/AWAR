import useTranslate from '@/shared/hooks/useTranslate'
import { Button } from '@/Components/_Base/Button'
import { PlusCircleIcon } from '@heroicons/react/24/outline'

interface FamilyFormProps {
    data?: any
}

export function FamilyForm(props: FamilyFormProps) {
    const __ = useTranslate()

    return (
        <div className="w-full gap-8 flex flex-col mb-8 min-h-0">
            <div className="space-y-4 flex flex-col h-full flex-1 min-h-0">
                <ol className="space-y-4 flex-1 pt-2 overflow-y-auto">
                    <li>
                        <p className="flex justify-between py-2.5 px-3.5 bg-ceiling rounded-md shadow">
                            <span className="text-gray-500">You</span>
                            <span>
                                {
                                    props.data.members.find(
                                        (m: any) => m.is_primary,
                                    )?.name
                                }
                            </span>
                        </p>
                    </li>
                    {props.data.members
                        .filter((m) => !m.is_primary)
                        .map((m) => (
                            <li>
                                <p className="flex justify-between py-2.5 px-3.5 bg-ceiling rounded-md shadow">
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
                                    <span>{m.name}</span>
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
