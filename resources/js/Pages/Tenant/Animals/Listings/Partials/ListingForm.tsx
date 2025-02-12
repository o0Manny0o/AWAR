import { Card } from '@/Components/Layout/Card'
import { FormEventHandler, useContext, useState } from 'react'
import useTranslate from '@/shared/hooks/useTranslate'
import { ListingFormWrapper } from '@/Pages/Tenant/Animals/Listings/Lib/Listings.context'
import TextAreaGroup from '@/Components/_Base/Input/TextAreaGroup'
import { SwitchInput } from '@/Components/_Base/Input'
import { truncateBeforeWord } from '@/shared/util'

interface ListingFormProps {
    formId: string
    data: ListingFormData
    setData: SetDataAction<ListingFormData>
    errors: Errors<ListingFormData>
    submitHandler: FormEventHandler
    clearErrors: (...keys: string[]) => void
}

export function ListingForm({
    data,
    setData,
    formId,
    errors,
    submitHandler,
    clearErrors,
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
                                    excerpt: truncateBeforeWord(v, 255),
                                    description: v,
                                })
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
            </div>
        </form>
    )
}
