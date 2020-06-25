// import React from "react";
// import { Redirect, Route } from "react-router-dom";
// import { HydraAdmin, hydraDataProvider as baseHydraDataProvider, fetchHydra as baseFetchHydra } from "@api-platform/admin";
// import parseHydraDocumentation from "@api-platform/api-doc-parser/lib/hydra/parseHydraDocumentation";
// import authProvider from "./authProvider";
//
// const entrypoint = 'http://localhost:20080/api/docs' //process.env.REACT_APP_API_ENTRYPOINT;
// const fetchHeaders = { Authorization: `Bearer ${window.localStorage.getItem('token')}` };
// const fetchHydra = (url, options = {}) => baseFetchHydra(url, {
    // ...options,
    // headers: new Headers(fetchHeaders),
// });
// const apiDocumentationParser = entrypoint => parseHydraDocumentation(entrypoint, { headers: new Headers(fetchHeaders) })
    // .then(
        // ({ api }) => ({ api }),
        // (result) => {
            // switch (result.status) {
                // case 401:
                    // return Promise.resolve({
                        // api: result.api,
                        // customRoutes: [
                            // <Route path="/" render={() => {
                                // return window.localStorage.getItem("token") ? window.location.reload() : <Redirect to="/login" />
                            // }} />
                        // ],
                    // });
//
                // default:
                    // return Promise.reject(result);
            // }
        // },
    // );
// const dataProvider = baseHydraDataProvider(entrypoint, fetchHydra, apiDocumentationParser);
//
// export default () => (
    // <HydraAdmin
        // dataProvider={ dataProvider }
        // authProvider={ authProvider }
        // entrypoint={ entrypoint }
    // />
// );
//
// https://api-platform.com/docs/admin/handling-relations/#display-a-field-of-an-embedded-relation
import React from "react";
import { 
  HydraAdmin,
  fetchHydra,
  hydraDataProvider
} from "@api-platform/admin";
import { parseHydraDocumentation } from "@api-platform/api-doc-parser";
import { ReferenceField, TextField } from "react-admin";

const entrypoint = 'http://localhost:20080'

const dataProvider = hydraDataProvider(
    entrypoint,
    fetchHydra,
    parseHydraDocumentation,
    true // useEmbedded parameter
);
// Replace with your own API entrypoint
// For instance if https://example.com/api/books is the path to the collection of book resources, then the entrypoint is https://example.com/api
export default () => (
  <HydraAdmin entrypoint={entrypoint}  dataProvider={ dataProvider } />
);
