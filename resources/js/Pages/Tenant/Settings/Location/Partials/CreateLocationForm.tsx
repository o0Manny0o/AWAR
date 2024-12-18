import { FormEventHandler, useContext, useMemo } from 'react'
import { useForm, usePage } from '@inertiajs/react'
import { Button } from '@/Components/_Base/Button'
import useTranslate from '@/shared/hooks/useTranslate'
import { LocationFormData } from '@/Pages/Tenant/Settings/Location/Lib/Location.types'
import { LocationFormWrapper } from '@/Pages/Tenant/Settings/Location/Lib/Location.context'
import { getCountry } from '@/shared/utils/getUserCountry'
import { LocationForm } from '@/Pages/Tenant/Settings/Location/Partials/LocationForm'
import Country = App.Models.Country

export default function CreateLocationForm() {
    const __ = useTranslate()
    const { countries } =
        usePage<AppPageProps<{ countries: Country[] }>>().props
    const { focusError } = useContext(LocationFormWrapper.Context)

    const country = useMemo(() => getCountry(countries), [countries])

    const { data, setData, errors, post, reset, processing } =
        useForm<LocationFormData>({
            name: '',
            public: false,
            street_address: '',
            postal_code: '',
            locality: '',
            region: '',
            country: country?.id ?? '',
        })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('settings.locations.store'), {
            preserveScroll: true,
            replace: true,
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }
    return (
        <form onSubmit={submitHandler} className="w-full space-y-6">
            <LocationForm data={data} setData={setData} errors={errors} />

            <Button className="w-full" disabled={processing}>
                {__('general.button.send', {
                    resource: '',
                })}
            </Button>
        </form>
    )
}
