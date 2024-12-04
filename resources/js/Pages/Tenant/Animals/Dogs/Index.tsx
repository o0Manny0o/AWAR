import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import usePermission from '@/shared/hooks/usePermission'
import List from '@/Components/Resource/List'
import Dog = App.Models.Dog

export default function Index({ dogs }: AppPageProps<{ dogs: Dog[] }>) {
    const __ = useTranslate()
    const { can } = usePermission()

    return (
        <AuthenticatedLayout
            title={__('animals.dogs.headers.index')}
            actionButtons={
                can('animals.create')
                    ? [
                          {
                              label: __('general.button.new', {
                                  resource: 'general.resources.animals.dog',
                              }),
                              variant: 'primary',
                              href: route('animals.dogs.create'),
                          },
                      ]
                    : []
            }
        >
            <Head title={__('animals.dogs.titles.index')} />

            <div className="">
                <Card>
                    <List
                        entities={dogs}
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
