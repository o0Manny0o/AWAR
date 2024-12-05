import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import usePermission from '@/shared/hooks/usePermission'
import List from '@/Components/Resource/List'
import Dog = App.Models.Dog
import { ShowActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'

export default function Index({ animals }: AppPageProps<{ animals: Dog[] }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            title={__('animals.dogs.headers.index')}
            actionButtons={ShowActionButtons(
                'general.resources.animals.dog',
                'animals.dogs.create',
            )}
        >
            <Head title={__('animals.dogs.titles.index')} />

            <div className="">
                <Card>
                    <List
                        entities={animals}
                        title={(a) => a.name}
                        subtitle={(a) => a.animalable.breed}
                        resourceUrl={'animals.dogs'}
                        resourceLabel={'general.resources.animals.dog'}
                    />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
