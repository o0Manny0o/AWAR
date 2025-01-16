import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import List from '@/Components/Resource/List'
import { IndexActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import { AnimalIndexTabs } from '@/Pages/Tenant/Animals/Partials/AnimalIndexTabs'
import Listing = App.Models.Listing

export default function Index({
    listings,
    type,
}: AppPageProps<{ listings: Listing[]; type: 'cats' | 'dogs' }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            title={__(`animals.${type}.headers.listings` as TranslationKey)}
            actionButtons={IndexActionButtons(
                `general.resources.animals.${type}.listing` as TranslationKey,
                `animals.${type}.listings.create`,
            )}
        >
            <Head
                title={__(`animals.${type}.titles.listings` as TranslationKey)}
            />

            <AnimalIndexTabs type={type} />

            <div className="mt-2">
                <Card>
                    <List
                        entities={listings}
                        title={(a) => a.animals.map((a) => a.name).join(', ')}
                        subtitle={(a) => a.excerpt}
                        resourceUrl={`animals.${type}.listings`}
                        resourceLabel={
                            `general.resources.animals.${type}.listing` as TranslationKey
                        }
                    />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
