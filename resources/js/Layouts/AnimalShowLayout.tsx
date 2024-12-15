import { PropsWithChildren } from 'react'
import AuthenticatedLayout, {
    AuthenticatedLayoutProps,
} from '@/Layouts/AuthenticatedLayout'
import { AssignInput } from '@/Pages/Tenant/Animals/Partials/AssignInput'
import { usePage } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import usePermission from '@/shared/hooks/usePermission'
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
    const { canAssignHandler, canAssignFosterHome } = usePermission()

    const { handlers, fosterHomes } = usePage<
        AppPageProps<{
            handlers: Pick<Member, 'id' | 'name'>[]
            fosterHomes: Pick<Member, 'id' | 'name'>[]
        }>
    >().props

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
                                canEdit={canAssignHandler(animal)}
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
                                canEdit={true}
                            />
                        </div>
                        <div className="pt-6">
                            <AssignInput
                                animal={animal}
                                label={__(
                                    'animals.form_general.foster_home.label',
                                )}
                                routeName={`${baseRoute}.assignFosterHome`}
                                options={fosterHomes}
                                value={animal.fosterHome}
                                prepend={
                                    <span className="bg-gray-300 size-6 rounded-full"></span>
                                }
                                canEdit={canAssignFosterHome(animal)}
                            />
                        </div>
                    </Card>
                </aside>
            </div>
        </AuthenticatedLayout>
    )
}
