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
import Location = App.Models.Location

export function AnimalShowLayout({
    animal,
    baseRoute,
    children,
    ...props
}: PropsWithChildren<{ animal: Animal; baseRoute: string }> &
    AuthenticatedLayoutProps) {
    const __ = useTranslate()
    const { canAssign } = usePermission()

    const { handlers, fosterHomes, locations } = usePage<
        AppPageProps<{
            handlers: Pick<Member, 'id' | 'name'>[]
            fosterHomes: Pick<Member, 'id' | 'name'>[]
            locations: Pick<Location, 'id' | 'name'>[]
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
                                routeName={`${baseRoute}.assign.handler`}
                                options={handlers}
                                value={animal.handler}
                                prepend={
                                    <span className="bg-gray-300 size-6 rounded-full shrink-0"></span>
                                }
                                canEdit={canAssign(animal)}
                            />
                        </div>

                        <div className="py-6">
                            <AssignInput
                                animal={animal}
                                label={__(
                                    'animals.form_general.foster_home.label',
                                )}
                                routeName={`${baseRoute}.assign.foster`}
                                options={fosterHomes}
                                value={animal.fosterHome}
                                prepend={
                                    <span className="bg-gray-300 size-6 rounded-full"></span>
                                }
                                canEdit={!!animal.can_assign_foster_home}
                            />
                        </div>
                        <div className="pt-6">
                            <AssignInput
                                animal={animal}
                                label={__(
                                    'animals.form_general.location.label',
                                )}
                                routeName={`${baseRoute}.assign.location`}
                                options={[
                                    ...locations?.map((l) => ({
                                        ...l,
                                        type: 'location',
                                    })),
                                    ...fosterHomes?.map((f) => ({
                                        ...f,
                                        type: 'foster_home',
                                    })),
                                ]}
                                value={animal.location}
                                prepend={
                                    <span className="bg-gray-300 size-6 rounded-full shrink-0"></span>
                                }
                                canEdit={!!animal.can_assign_location}
                                withType={'foster_home'}
                                emptyOption={
                                    'general.various.unknown_or_external'
                                }
                            />
                        </div>
                    </Card>
                </aside>
            </div>
        </AuthenticatedLayout>
    )
}
