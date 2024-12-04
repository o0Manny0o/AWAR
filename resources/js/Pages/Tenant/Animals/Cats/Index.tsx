import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import usePermission from '@/shared/hooks/usePermission'
import List from '@/Components/Resource/List'
import Dog = App.Models.Dog

export default function Index({ cats }: AppPageProps<{ cats: Dog[] }>) {
    const __ = useTranslate()
    const { can } = usePermission()

    return (
        <AuthenticatedLayout
            title={__('animals.cats.headers.index')}
            actionButtons={
                can('animals.create')
                    ? [
                          {
                              label: __('general.button.new', {
                                  resource: 'general.resources.animals.cat',
                              }),
                              variant: 'primary',
                              href: route('animals.cats.create'),
                          },
                      ]
                    : []
            }
        >
            <Head title={__('animals.cats.titles.index')} />

            <div className="">
                <Card>
                    <List
                        entities={cats}
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
