import AutocompleteGroup from '@/Components/_Base/Input/AutocompleteGroup'
import useTranslate from '@/shared/hooks/useTranslate'
import Family = App.Models.Family
import Animal = App.Models.Animal
import { usePage } from '@inertiajs/react'

interface FamilyGroupProps<TForm> {
    families: Family[]
    mothers: Animal[]
    fathers: Animal[]
    data: TForm
    setData: SetDataAction<TForm>
    errors: Errors<TForm>
}

export function FamilyGroup<TForm extends Record<string, any>>({
    families,
    mothers,
    fathers,
    data,
    setData,
    errors,
}: FamilyGroupProps<TForm>) {
    const __ = useTranslate()
    const { locale } = usePage().props

    return (
        <>
            <AutocompleteGroup
                canCreate
                options={families}
                name="family"
                placeholder={__('animals.dogs.form.family.placeholder')}
                value={data.family}
                label={__('animals.dogs.form.family.label')}
                error={errors.family}
                onChange={(value) => {
                    setData((prev) => ({
                        ...prev,
                        family: value?.id ?? null,
                        mother: value?.mother?.id ?? null,
                        father: value?.father?.id ?? null,
                    }))
                }}
                description={(value: Family) =>
                    `Created ${new Date(value.updated_at).toLocaleDateString(locale)} ${value.mother ? 'Mother: ' + value.mother.name : ''}`
                }
            />

            {data.family && (
                <>
                    <AutocompleteGroup
                        name={'mother'}
                        options={mothers}
                        label={'mother'}
                        value={data.mother ?? ''}
                        error={errors.mother}
                        onChange={(value) => {
                            setData((prev) => ({
                                ...prev,
                                mother: value?.id,
                                father:
                                    value?.id === prev.father
                                        ? null
                                        : prev.father,
                            }))
                        }}
                        withEmptyOption={'Unknown'}
                    />

                    <AutocompleteGroup
                        name={'father'}
                        options={fathers}
                        error={errors.father}
                        label={'father'}
                        value={data.father ?? ''}
                        onChange={(value) => {
                            setData((prev) => ({
                                ...prev,
                                father: value?.id,
                                mother:
                                    value?.id === prev.mother
                                        ? null
                                        : prev.mother,
                            }))
                        }}
                        withEmptyOption={'Unknown'}
                    />
                </>
            )}
        </>
    )
}
