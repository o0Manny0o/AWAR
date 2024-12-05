import {
    Context,
    createContext,
    createRef,
    Dispatch,
    PropsWithChildren,
    RefObject,
    SetStateAction,
    useMemo,
    useState,
} from 'react'

export interface FormContextWrapper<T extends Record<string, RefObject<any>>> {
    Context: Context<FormContextData<T>>
    _fields: (keyof T)[]
}

type Errors<T> = {
    [Key in keyof T]: string
}

export interface FormContextData<T extends Record<string, RefObject<any>>> {
    focus: (id: keyof T) => void
    focusError: (errors: Errors<T>) => void
    refs: T
    processing: boolean
    setProcessing: Dispatch<SetStateAction<boolean>>
}

export const FormContext = <T extends Record<string, RefObject<any>>>(
    fields: (keyof T)[],
): FormContextWrapper<T> => ({
    Context: createContext<FormContextData<T>>({
        focus: () => console.error('No Context'),
        focusError: () => console.error('No Context'),
        refs: {} as T,
        processing: false,
        setProcessing: () => console.error('No Context'),
    }),
    _fields: fields,
})

export function FormContextProvider<T extends Record<string, RefObject<any>>>({
    context: { Context, _fields },
    children,
}: PropsWithChildren<{
    context: FormContextWrapper<T>
}>) {
    const [processing, setProcessing] = useState(false)

    const inputRefs = useMemo(
        () =>
            Object.fromEntries(
                _fields.map((id) => [id, createRef<HTMLElement>()]),
            ),
        [_fields],
    ) as T

    const focus = (id: keyof T) => inputRefs[id].current?.focus()

    const focusError = (errors: Errors<T>) => {
        for (const f of _fields) {
            if (errors[f]) {
                focus(f)
                break
            }
        }
    }

    return (
        <Context.Provider
            value={{
                refs: inputRefs,
                focus,
                focusError,
                processing,
                setProcessing,
            }}
        >
            {children}
        </Context.Provider>
    )
}
