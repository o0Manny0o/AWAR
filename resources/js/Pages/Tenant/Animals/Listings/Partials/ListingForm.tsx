import { Card } from '@/Components/Layout/Card'
import { FormEventHandler, useContext, useState } from 'react'
import useTranslate from '@/shared/hooks/useTranslate'
import { ListingFormWrapper } from '@/Pages/Tenant/Animals/Listings/Lib/Listings.context'
import TextAreaGroup from '@/Components/_Base/Input/TextAreaGroup'
import { SwitchInput } from '@/Components/_Base/Input'
import { getArrayErrors, truncateBeforeWord } from '@/shared/util'
import { ResourceMultiSelect } from '@/Components/_Base/Input/ResourceMultiSelect'
import { Option } from '@/Components/_Base/Input/AutocompleteInput'
import { ImageSelect } from '@/Components/_Base/Input/Images/ImageSelect'
import Animal = App.Models.Animal
import AnimalType = App.Models.AnimalType

interface ListingFormProps {
    formId: string
    data: ListingFormData
    setData: SetDataAction<ListingFormData>
    errors: Errors<ListingFormData>
    submitHandler: FormEventHandler
    clearErrors: (...keys: string[]) => void
    animals: AsOption<Animal>[]
    type: AnimalType
}

export function ListingForm({
    data,
    setData,
    formId,
    errors,
    submitHandler,
    animals,
    type,
}: ListingFormProps) {
    const __ = useTranslate()
    const {
        refs: { excerpt, description },
    } = useContext(ListingFormWrapper.Context)

    const [useDescription, setUseDescription] = useState(false)

    return (
        <form id={formId} onSubmit={submitHandler}>
            <div className="space-y-6 py-6">
                <Card className="gap-4">
                    <TextAreaGroup
                        name="description"
                        ref={description}
                        label={__('animals.listings.form.description.label')}
                        placeholder={__(
                            'animals.listings.form.description.placeholder',
                        )}
                        maxLength={10000}
                        value={data.description}
                        onChange={(v) => {
                            if (useDescription) {
                                setData({
                                    ...data,
                                    excerpt: truncateBeforeWord(v, 255),
                                    description: v,
                                } as ListingFormData)
                            } else {
                                setData('description', v)
                            }
                        }}
                        error={errors.description}
                    />

                    <TextAreaGroup
                        name="excerpt"
                        ref={excerpt}
                        label={__('animals.listings.form.excerpt.label')}
                        placeholder={__(
                            'animals.listings.form.excerpt.placeholder',
                        )}
                        readOnly={useDescription}
                        value={
                            data.excerpt +
                            (useDescription &&
                            data.description.length > data.excerpt.length
                                ? '...'
                                : '')
                        }
                        onChange={(v) => setData('excerpt', v)}
                        error={errors.excerpt}
                    />

                    <SwitchInput
                        label={__(
                            'animals.listings.form.excerpt.use_description',
                        )}
                        name="is_active"
                        checked={useDescription}
                        onChange={(v) => {
                            setUseDescription(v)
                            setData(
                                'excerpt',
                                truncateBeforeWord(data.description, 255),
                            )
                        }}
                    />
                </Card>

                <Card className="gap-4">
                    <ResourceMultiSelect
                        name={'animals'}
                        label={__('animals.listings.form.animals.label')}
                        values={data.animals as Option[]}
                        error={Object.values(
                            getArrayErrors(errors, 'animals'),
                        )?.join()}
                        options={animals}
                        onChange={(values) =>
                            setData('animals', values as Animal[])
                        }
                        resourceThumbnail={(animal) =>
                            (animal as Animal).thumbnail ?? ''
                        }
                        resourceURL={(animal) =>
                            route(`animals.${type}.show`, animal.id)
                        }
                        subtitle={(animal) => (animal as Animal).family?.name}
                    />
                </Card>

                <Card>
                    <ImageSelect
                        label={__('animals.listings.form.images.label')}
                        images={
                            data.animals
                                ?.map((a) =>
                                    a.media.map((m) => ({
                                        ...m,
                                        animal: a.name,
                                    })),
                                )
                                .flat() ?? []
                        }
                        selected={data.images}
                        onSelect={(m) =>
                            setData('images', [...data.images, m.id])
                        }
                        onRemove={(m) =>
                            setData(
                                'images',
                                data.images.filter((id) => id !== m.id),
                            )
                        }
                        title={(i) => (i as any).animal}
                    />
                </Card>
            </div>
        </form>
    )
}
