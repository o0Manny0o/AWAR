import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import usePermission from '@/shared/hooks/usePermission'
import List from '@/Components/Resource/List'
import { ShowActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import Dog = App.Models.Dog

export default function Index({ animals }: AppPageProps<{ animals: Dog[] }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            title={__('animals.cats.headers.index')}
            actionButtons={ShowActionButtons(
                'general.resources.animals.cat',
                'animals.cats.create',
            )}
        >
            <Head title={__('animals.cats.titles.index')} />

            <div className="">
                <Card>
                    <List
                        entities={animals}
                        title={(a) => a.name}
                        subtitle={(a) => a.animalable.breed}
                        resourceUrl={'animals.cats'}
                        resourceLabel={'general.resources.cats.dog'}
                    />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
