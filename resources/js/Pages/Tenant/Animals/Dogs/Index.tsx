import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import List from '@/Components/Resource/List'
import { IndexActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import Dog = App.Models.Dog
import { Badge } from '@/Components/_Base/Badge'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Tenant/Animals/Lib/Animals.util'

export default function Index({ animals }: AppPageProps<{ animals: Dog[] }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            title={__('animals.dogs.headers.index')}
            actionButtons={IndexActionButtons(
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
                        badge={(a) => (
                            <Badge color={badgeColor(a)}>
                                {__(badgeLabelKey(a))}
                            </Badge>
                        )}
                        resourceLabel={'general.resources.animals.dog'}
                    />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
