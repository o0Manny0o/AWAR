import InputLabel from '@/Components/_Base/Input/InputLabel'
import InputError from '@/Components/_Base/Input/InputError'
import { forwardRef, useImperativeHandle, useRef } from 'react'
import SelectInput, {
    SelectInputProps,
} from '@/Components/_Base/Input/SelectInput'

type SelectGroupProps = SelectInputProps & {
    label: string
    name: string
    error?: string
}

export default forwardRef(function InputGroup(
    { label, name, error, ...props }: SelectGroupProps,
    ref,
) {
    const localRef = useRef<HTMLSelectElement>(null)

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }))

    return (
        <div>
            <InputLabel htmlFor={name} value={label} />

            <SelectInput {...props} name={name} ref={localRef} />

            <InputError message={error} className="mt-2" />
        </div>
    )
})
