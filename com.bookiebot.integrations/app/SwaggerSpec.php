<?php
/**
 * @SWG\Swagger(
 *
 *     basePath="/api",
 *     host="localhost:8000",
 *     schemes={"http","https"},
 *     consumes={"application/json","application/x-www-form-urlencoded"},
 *
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Swagger 2.0 -  Games Integration System (Singular)",
 *         description="API Which Integrates Different Game Providers With Casino Core Systems",
 *         @SWG\Contact(name="Singular API Team"),
 *         @SWG\License(name="MIT")
 *     ),
 *
 *
 *     @SWG\Definition(
 *         definition="errorModel",
 *         required={"code", "error_code", "error_message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="error_code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     ),
 *
 *     @SWG\Definition(
 *         definition="successModel",
 *         required={"code", "message", "data"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         ),
 *         @SWG\Property(
 *             property="data",
 *             type="object"
 *         )
 *     )
 *
 *
 * )
 */