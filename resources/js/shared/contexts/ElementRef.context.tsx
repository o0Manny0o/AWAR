import {
    Context,
    createContext,
    createRef,
    PropsWithChildren,
    RefObject,
    useMemo,
} from 'react'

export interface ElementRefContextWrapper<
    T extends Record<string, RefObject<any>>,
> {
    Context: Context<ElementRefContextData<T>>
    _fields: (keyof T)[]
}

type Errors<T> = {
    [Key in keyof T]: string
}

interface ElementRefContextData<T extends Record<string, RefObject<any>>> {
    focus: (id: keyof T) => void
    focusError: (errors: Errors<T>) => void
    refs: T
}

export const ElementRefContext = <T extends Record<string, RefObject<any>>>(
    fields: (keyof T)[],
): ElementRefContextWrapper<T> => ({
    Context: createContext<ElementRefContextData<T>>({
        focus: () => console.error('No Context'),
        focusError: () => console.error('No Context'),
        refs: {} as T,
    }),
    _fields: fields,
})

export function ElementRefProvider<T extends Record<string, RefObject<any>>>({
    context: { Context, _fields },
    children,
}: PropsWithChildren<{
    context: ElementRefContextWrapper<T>
}>) {
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
            }}
        >
            {children}
        </Context.Provider>
    )
}
