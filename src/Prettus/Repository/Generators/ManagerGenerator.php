<?php

namespace Prettus\Repository\Generators;

/**
 * Class ManagerGenerator
 * @package Prettus\Repository\Generators
 */
class ManagerGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'manager/manager';

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return parent::getRootNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode());
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'managers';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {

        return $this->getBasePath() . DIRECTORY_SEPARATOR . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true). DIRECTORY_SEPARATOR .$this->getName() . DIRECTORY_SEPARATOR . $this->getManagerName() . '.php';
    }


    /**
     * Gets controller name based on model;
     *
     * @return string
     */
    public function getManagerName()
    {

        return ucfirst($this->option('action'));
    }
    /**
     * Gets plural name based on model
     *
     * @return string
     */
    public function getPluralName()
    {
        return str_plural(lcfirst(ucwords($this->getClass())));
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('repository.generator.basePath', app_path());
    }


    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {

        return array_merge(parent::getReplacements(), [
            'validator'  => $this->getValidator(),
            'repository' => $this->getRepository(),
            'namespace'      => 'namespace '. $this->getRootNamespace().'\\'.$this->getName().';',
            'appname'    => $this->getAppNamespace(),
            'managername'      => $this->getManagerName(),
        ]);
    }

    /**
     * Gets validator full class name
     *
     * @return string
     */
    public function getValidator()
    {
        $validatorGenerator = new ValidatorGenerator([
            'name' => $this->name,
        ]);

        $validator = $validatorGenerator->getRootNamespace() . '\\' . $validatorGenerator->getName();

        return 'use ' . str_replace([
            "\\",
            '/'
        ], '\\', $validator) . 'Validator;';
    }


    /**
     * Gets repository full class name
     *
     * @return string
     */
    public function getRepository()
    {
        $repositoryGenerator = new RepositoryInterfaceGenerator([
            'name' => $this->name,
        ]);

        $repository = $repositoryGenerator->getRootNamespace() . '\\' . $repositoryGenerator->getName();

        return 'use ' . str_replace([
            "\\",
            '/'
        ], '\\', $repository) . 'Repository;';
    }

}