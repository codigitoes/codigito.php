import React from "react";

type UseFetchState<T> = {
    state: 'idle' | 'loading' | 'error' | 'success';
    data: null | T;
    error: Error | null;
}

export default function useFetch<T>(url: string) {
    const [fetchState, setFetchState] = React.useState<UseFetchState<T>>({
        state: 'idle',
        data: null,
        error: null
    });

    React.useEffect(() => {
        async function fetchData() {
            try {
                setFetchState({
                    ...fetchState,
                    state: 'loading'
                });

                const response = await fetch(url)
                if (response.ok) {
                    const data = await response.json();
                    setFetchState({
                        data: data,
                        error: null,
                        state: 'success'
                    });
                }
                if (response.ok === false) {
                    setFetchState({
                        data: null,
                        state: 'error',
                        error: new Error(response.statusText)
                    });
                }
            } catch (error) {
                setFetchState({
                    data: null,
                    state: 'error',
                    error: error as Error
                });
            }
        }

        fetchData();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [url]);

    return fetchState;
}