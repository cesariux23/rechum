import axios, {AxiosInstance} from 'axios'
import { inject } from 'vue'
import type { InjectionKey } from 'vue'
import type { App } from 'vue'

interface AxiosOptions {
    baseUrl: string,
    token?: string
}

const injectionKey = Symbol('http') as InjectionKey<AxiosInstance>

export const useHttp = () => inject(injectionKey)

export default {
    install: (app:App, options: AxiosOptions) => {
        const http = axios.create({
            baseURL: options.baseUrl,
            headers: {
                Authorization: options.token ? `Bearer ${options.token}` : '',
            }
        })
        app.provide(injectionKey, http)
        // It is common to use both `app.config.globalProperties`
        // and `provide` in the same plugin
        app.config.globalProperties.$http = http
    }
}