<?php

namespace Meetupos\AuthApiBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Knp\FriendlyContexts\Context\EntityContext;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Defines application features from the specific context.
 */
class DataContext extends EntityContext implements Context, SnippetAcceptingContext
{

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

    }

    /**
     * @param string $id
     *
     * @return object
     */
    protected function getService($id)
    {
        return $this->getContainer()->get($id);
    }

//    /**
//     * @Then /^should be (\d+) (.*) like:?$/
//     */
//    public function shouldBeLikeFollowing($nbr, $name, TableNode $table)
//    {
//        $entityName = $this->resolveEntity($name)->getName();
//
//        $rows = $table->getRows();
//        $headers = array_shift($rows);
//
//        $accessor = PropertyAccess::createPropertyAccessor();
//
//        for ($i = 0; $i < $nbr; $i++) {
//            $row = $rows[$i % count($rows)];
//
//            $values = array_combine($headers, $row);
//            $object = $this->getEntityManager()
//                ->getRepository($entityName)
//                ->findOneBy(
//                    $this->getEntityIdentifiers($entityName, $headers, $row)
//                );
//            if (is_null($object)) {
//                throw new \Exception(sprintf("There is not any object for the following identifiers: %s", json_encode($this->getEntityIdentifiers($entityName, $headers, $row))));
//            }
//            $this->getEntityManager()->refresh($object);
//            foreach ($values as $key => $value) {
//
//                if ($value != $accessor->getValue($object, $key) ) {
//                    throw new \Exception("The expected object does not have property $key with value $value");
//                }
//            }
//
//        }
//    }

    /**
     * @Then /^should not be (\d+) (.*) like:?$/
     */
    public function shouldNotBeLikeFollowing($nbr, $name, TableNode $table)
    {
        $entityName = $this->resolveEntity($name)->getName();

        $rows = $table->getRows();
        $headers = array_shift($rows);

        for ($i = 0; $i < $nbr; $i++) {
            $row = $rows[$i % count($rows)];

            $object = $this->getEntityManager()
                ->getRepository($entityName)
                ->findOneBy(
                    $this->getEntityIdentifiers($entityName, $headers, $row)
                );

            if (!is_null($object)) {
                throw new \Exception(sprintf("There is an object for the following identifiers: %s", json_encode($this->getEntityIdentifiers($entityName, $headers, $row))));
            }
        }
    }

}
