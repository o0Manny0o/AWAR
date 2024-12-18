import { FormEventHandler, useContext, useMemo } from 'react'
import { useForm, usePage } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { LocationFormData } from '@/Pages/Tenant/Settings/Location/Lib/Location.types'
import { LocationFormWrapper } from '@/Pages/Tenant/Settings/Location/Lib/Location.context'
import { getCountry } from '@/shared/utils/getUserCountry'
import { LocationForm } from '@/Pages/Tenant/Settings/Location/Partials/LocationForm'
import Country = App.Models.Country
import Location = App.Models.Location

export default function UpdateLocationForm({
    location,
    formId,
}: {
    location: Location
    formId: string
}) {
    const __ = useTranslate()
    const { countries } =
        usePage<AppPageProps<{ countries: Country[] }>>().props

    const { focusError } = useContext(LocationFormWrapper.Context)

    const country = useMemo(() => getCountry(countries), [countries])

    const { data, setData, errors, patch, reset, processing } =
        useForm<LocationFormData>({
            name: location.name ?? '',
            public: location.public ?? false,
            street_address: location.address.street_address ?? '',
            postal_code: location.address.postal_code ?? '',
            locality: location.address.locality ?? '',
            region: location.address.region ?? '',
            country: location.address.country.id ?? country?.id ?? '',
        })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('settings.locations.update', location.id), {
            preserveScroll: true,
            replace: true,
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }
    return (
        <form onSubmit={submitHandler} id={formId} className="w-full space-y-6">
            <LocationForm data={data} errors={errors} setData={setData} />
        </form>
    )
}
