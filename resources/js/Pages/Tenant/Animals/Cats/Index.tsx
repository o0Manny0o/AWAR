import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import List from '@/Components/Resource/List'
import { Badge } from '@/Components/_Base/Badge'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Tenant/Animals/Lib/Animals.util'
import { AnimalIndexTabs } from '@/Pages/Tenant/Animals/Partials/AnimalIndexTabs'
import { CreateActionButton } from '@/shared/utils/buttons'
import Dog = App.Models.Dog

export default function Index({ animals }: AppPageProps<{ animals: Dog[] }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            title={__('animals.cats.headers.index')}
            actionButtons={CreateActionButton(
                'general.resources.animals.cat',
                'animals.cats.create',
            )}
        >
            <Head title={__('animals.cats.titles.index')} />

            <AnimalIndexTabs type={'cats'} />

            <div className="mt-2">
                <Card>
                    <List
                        entities={animals}
                        title={(a) => a.name}
                        subtitle={(a) => a.animalable.breed}
                        resourceUrl={'animals.cats'}
                        badge={(a) => (
                            <Badge color={badgeColor(a)}>
                                {__(badgeLabelKey(a))}
                            </Badge>
                        )}
                        resourceLabel={'general.resources.animals.cat'}
                    />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
