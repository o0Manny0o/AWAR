import { PropsWithChildren } from 'react'
import AuthenticatedLayout, {
    AuthenticatedLayoutProps,
} from '@/Layouts/AuthenticatedLayout'
import { AssignInput } from '@/Pages/Tenant/Animals/Partials/AssignInput'
import { usePage } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import Animal = App.Models.Animal
import Member = App.Models.Member

export function AnimalShowLayout({
    animal,
    baseRoute,
    children,
    ...props
}: PropsWithChildren<{ animal: Animal; baseRoute: string }> &
    AuthenticatedLayoutProps) {
    const __ = useTranslate()
    const { handlers } =
        usePage<AppPageProps<{ handlers: Pick<Member, 'id' | 'name'>[] }>>()
            .props

    return (
        <AuthenticatedLayout {...props}>
            <div className="grid grid-cols-8 gap-4">
                <div className="col-span-8 md:col-span-6">{children}</div>
                <aside className="col-span-8 md:col-span-2 overflow-y-auto">
                    <Card bodyClassName="divide-y divide-gray-200 space-y-0">
                        <div className="pb-6">
                            <AssignInput
                                animal={animal}
                                label={__('general.various.assigned_to')}
                                routeName={`${baseRoute}.assign`}
                                options={handlers}
                                value={animal.handler}
                                prepend={
                                    <span className="bg-gray-300 size-6 rounded-full shrink-0"></span>
                                }
                            />
                        </div>
                        <div className="py-6">
                            <AssignInput
                                animal={animal}
                                label={__(
                                    'animals.form_general.location.label',
                                )}
                                routeName={'animals.location'}
                                options={[]}
                                value={{ id: '1', name: 'Shelter XYZ' }}
                            />
                        </div>
                        <div className="pt-6">
                            <AssignInput
                                animal={animal}
                                label={__(
                                    'animals.form_general.foster_home.label',
                                )}
                                routeName={'animals.location'}
                                options={[]}
                                value={{ id: '1', name: 'Moritz Wach' }}
                                prepend={
                                    <span className="bg-gray-300 size-6 rounded-full"></span>
                                }
                            />
                        </div>
                    </Card>
                </aside>
            </div>
        </AuthenticatedLayout>
    )
}
